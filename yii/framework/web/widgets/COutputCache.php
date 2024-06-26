<?php
/**
 * COutputCache class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link https://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

/**
 * COutputCache enables caching the output generated by an action or a view fragment.
 *
 * If the output to be displayed is found valid in cache, the cached
 * version will be displayed instead, which saves the time for generating
 * the original output.
 *
 * Since COutputCache extends from {@link CFilterWidget}, it can be used
 * as either a filter (for action caching) or a widget (for fragment caching).
 * For the latter, the shortcuts {@link CBaseController::beginCache()} and {@link CBaseController::endCache()}
 * are often used instead, like the following in a view file:
 * <pre>
 * if($this->beginCache('cacheName',array('property1'=>'value1',...))
 * {
 *     // ... display the content to be cached here
 *    $this->endCache();
 * }
 * </pre>
 *
 * COutputCache must work with a cache application component specified via {@link cacheID}.
 * If the cache application component is not available, COutputCache will be disabled.
 *
 * The validity of the cached content is determined based on two factors:
 * the {@link duration} and the cache {@link dependency}.
 * The former specifies the number of seconds that the data can remain
 * valid in cache (defaults to 60s), while the latter specifies conditions
 * that the cached data depends on. If a dependency changes,
 * (e.g. relevant data in DB are updated), the cached data will be invalidated.
 * For more details about cache dependency, see {@link CCacheDependency}.
 *
 * Sometimes, it is necessary to turn off output caching only for certain request types.
 * For example, we only want to cache a form when it is initially requested;
 * any subsequent display of the form should not be cached because it contains user input.
 * We can set {@link requestTypes} to be <code>array('GET')</code> to accomplish this task.
 *
 * The content fetched from cache may be variated with respect to
 * some parameters. COutputCache supports four kinds of variations:
 * <ul>
 * <li>{@link varyByRoute}: this specifies whether the cached content
 *   should be varied with the requested route (controller and action)</li>
 * <li>{@link varyByParam}: this specifies a list of GET parameter names
 *   and uses the corresponding values to determine the version of the cached content.</li>
 * <li>{@link varyBySession}: this specifies whether the cached content
 *   should be varied with the user session.</li>
 * <li>{@link varyByExpression}: this specifies whether the cached content
 *   should be varied with the result of the specified PHP expression.</li>
 * <li>{@link varyByLanguage}: this specifies whether the cached content
 *   should by varied with the user's language. Available since 1.1.14.</li>
 * </ul>
 * For more advanced variation, override {@link getBaseCacheKey()} method.
 *
 * @property boolean $isContentCached Whether the content can be found from cache.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web.widgets
 * @since 1.0
 */
class COutputCache extends CFilterWidget
{
	/**
	 * Prefix to the keys for storing cached data
	 */
	const CACHE_KEY_PREFIX='Yii.COutputCache.';

	/**
	 * @var integer number of seconds that the data can remain in cache. Defaults to 60 seconds.
	 * If it is 0, existing cached content would be removed from the cache.
	 * If it is a negative value, the cache will be disabled (any existing cached content will
	 * remain in the cache.)
	 *
	 * Note, if cache dependency changes or cache space is limited,
	 * the data may be purged out of cache earlier.
	 */
	public $duration=60;
	/**
	 * @var boolean whether the content being cached should be differentiated according to route.
	 * A route consists of the requested controller ID and action ID.
	 * Defaults to true.
	 */
	public $varyByRoute=true;
	/**
	 * @var boolean whether the content being cached should be differentiated according to user sessions. Defaults to false.
	 */
	public $varyBySession=false;
	/**
	 * @var array list of GET parameters that should participate in cache key calculation.
	 * By setting this property, the output cache will use different cached data
	 * for each different set of GET parameter values.
	 */
	public $varyByParam;
	/**
	 * @var string a PHP expression whose result is used in the cache key calculation.
	 * By setting this property, the output cache will use different cached data
	 * for each different expression result.
	 * The expression can also be a valid PHP callback,
	 * including class method name (array(ClassName/Object, MethodName)),
	 * or anonymous function (PHP 5.3.0+). The function/method signature should be as follows:
	 * <pre>
	 * function foo($cache) { ... }
	 * </pre>
	 * where $cache refers to the output cache component.
	 *
	 * The PHP expression will be evaluated using {@link evaluateExpression}.
	 *
	 * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
	 * please refer to the {@link https://www.php.net/manual/en/language.expressions.php php manual}.
	 */
	public $varyByExpression;
	/**
	 * @var boolean whether the content being cached should be differentiated according to user's language.
	 * A language is retrieved via Yii::app()->language.
	 * Defaults to false.
	 * @since 1.1.14
	 */
	public $varyByLanguage=false;
	/**
	 * @var array list of request types (e.g. GET, POST) for which the cache should be enabled only.
	 * Defaults to null, meaning all request types.
	 */
	public $requestTypes;
	/**
	 * @var string the ID of the cache application component. Defaults to 'cache' (the primary cache application component.)
	 */
	public $cacheID='cache';
	/**
	 * @var mixed the dependency that the cached content depends on.
	 * This can be either an object implementing {@link ICacheDependency} interface or an array
	 * specifying the configuration of the dependency object. For example,
	 * <pre>
	 * array(
	 *     'class'=>'CDbCacheDependency',
	 *     'sql'=>'SELECT MAX(lastModified) FROM Post',
	 * )
	 * </pre>
	 * would make the output cache depends on the last modified time of all posts.
	 * If any post has its modification time changed, the cached content would be invalidated.
	 */
	public $dependency;

	private $_key;
	private $_cache;
	private $_contentCached;
	private $_content;
	private $_actions;

	/**
	 * Performs filtering before the action is executed.
	 * This method is meant to be overridden by child classes if begin-filtering is needed.
	 * @param CFilterChain $filterChain list of filters being applied to an action
	 * @return boolean whether the filtering process should stop after this filter. Defaults to false.
	 */
	public function filter($filterChain)
	{
		if(!$this->getIsContentCached())
			$filterChain->run();
		$this->run();
	}

	/**
	 * Marks the start of content to be cached.
	 * Content displayed after this method call and before {@link endCache()}
	 * will be captured and saved in cache.
	 * This method does nothing if valid content is already found in cache.
	 */
	public function init()
	{
		if($this->getIsContentCached())
			$this->replayActions();
		elseif($this->_cache!==null)
		{
			$this->getController()->getCachingStack()->push($this);
			ob_start();
			ob_implicit_flush(false);
		}
	}

	public function html_entities($text)
	{
		return htmlentities($text,ENT_QUOTES,'UTF-8');
	}

	/**
	 * Marks the end of content to be cached.
	 * Content displayed before this method call and after {@link init()}
	 * will be captured and saved in cache.
	 * This method does nothing if valid content is already found in cache.
	 */
	public function run()
	{
		if($this->getIsContentCached())
		{
			if($this->getController()->isCachingStackEmpty())
				echo $this->html_entities($this->getController()->processDynamicOutput($this->_content));
			else
				echo $this->html_entities($this->_content);
		}
		elseif($this->_cache!==null)
		{
			$this->_content=ob_get_clean();
			$this->getController()->getCachingStack()->pop();
			$data=array($this->_content,$this->_actions);
			if(is_array($this->dependency))
				$this->dependency=Yii::createComponent($this->dependency);
			$this->_cache->set($this->getCacheKey(),$data,$this->duration,$this->dependency);

			if($this->getController()->isCachingStackEmpty())
				echo $this->html_entities($this->getController()->processDynamicOutput($this->_content));
			else
				echo $this->html_entities($this->_content);
		}
	}

	/**
	 * @return boolean whether the content can be found from cache
	 */
	public function getIsContentCached()
	{
		if($this->_contentCached!==null)
			return $this->_contentCached;
		else
			return $this->_contentCached=$this->checkContentCache();
	}

	/**
	 * Looks for content in cache.
	 * @return boolean whether the content is found in cache.
	 */
	protected function checkContentCache()
	{
		if((empty($this->requestTypes) || in_array(Yii::app()->getRequest()->getRequestType(),$this->requestTypes))
			&& ($this->_cache=$this->getCache())!==null)
		{
			if($this->duration>0 && ($data=$this->_cache->get($this->getCacheKey()))!==false)
			{
				$this->_content=$data[0];
				$this->_actions=$data[1];
				return true;
			}
			if($this->duration==0)
				$this->_cache->delete($this->getCacheKey());
			if($this->duration<=0)
				$this->_cache=null;
		}
		return false;
	}

	/**
	 * @return ICache the cache used for caching the content.
	 */
	protected function getCache()
	{
		return Yii::app()->getComponent($this->cacheID);
	}

	/**
	 * Caclulates the base cache key.
	 * The calculated key will be further variated in {@link getCacheKey}.
	 * Derived classes may override this method if more variations are needed.
	 * @return string basic cache key without variations
	 */
	protected function getBaseCacheKey()
	{
		return self::CACHE_KEY_PREFIX.$this->getId().'.';
	}

	/**
	 * Calculates the cache key.
	 * The key is calculated based on {@link getBaseCacheKey} and other factors, including
	 * {@link varyByRoute}, {@link varyByParam}, {@link varyBySession} and {@link varyByLanguage}.
	 * @return string cache key
	 */
	protected function getCacheKey()
	{
		if($this->_key!==null)
			return $this->_key;
		else
		{
			$key=$this->getBaseCacheKey().'.';
			if($this->varyByRoute)
			{
				$controller=$this->getController();
				$key.=$controller->getUniqueId().'/';
				if(($action=$controller->getAction())!==null)
					$key.=$action->getId();
			}
			$key.='.';

			if($this->varyBySession)
				$key.=Yii::app()->getSession()->getSessionID();
			$key.='.';

			if(is_array($this->varyByParam) && isset($this->varyByParam[0]))
			{
				$params=array();
				foreach($this->varyByParam as $name)
				{
					if(isset($_GET[$name]))
						$params[$name]=$_GET[$name];
					else
						$params[$name]='';
				}
				$key.=serialize($params);
			}
			$key.='.';

			if($this->varyByExpression!==null)
				$key.=$this->evaluateExpression($this->varyByExpression);
			$key.='.';

			if($this->varyByLanguage)
				$key.=Yii::app()->language;
			$key.='.';

			return $this->_key=$key;
		}
	}

	/**
	 * Records a method call when this output cache is in effect.
	 * When the content is served from the output cache, the recorded
	 * method will be re-invoked.
	 * @param string $context a property name of the controller. The property should refer to an object
	 * whose method is being recorded. If empty it means the controller itself.
	 * @param string $method the method name
	 * @param array $params parameters passed to the method
	 */
	public function recordAction($context,$method,$params)
	{
		$this->_actions[]=array($context,$method,$params);
	}

	/**
	 * Replays the recorded method calls.
	 */
	protected function replayActions()
	{
		if(empty($this->_actions))
			return;
		$controller=$this->getController();
		$cs=Yii::app()->getClientScript();
		foreach($this->_actions as $action)
		{
			if($action[0]==='clientScript')
				$object=$cs;
			elseif($action[0]==='')
				$object=$controller;
			else
				$object=$controller->{$action[0]};
			if(method_exists($object,$action[1]))
				call_user_func_array(array($object,$action[1]),$action[2]);
			elseif($action[0]==='' && function_exists($action[1]))
				call_user_func_array($action[1],$action[2]);
			else
				throw new CException(Yii::t('yii','Unable to replay the action "{object}.{method}". The method does not exist.',
					array('object'=>$action[0],
						'method'=>$action[1])));
		}
	}
}
