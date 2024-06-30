<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
date_default_timezone_set('Asia/Jakarta');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
$config = array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'language' => 'id',
    'name' => 'KIOSK Efisiensi',
    'defaultController' => 'front',
    'theme' => 'adminlte',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.controllers.*',
        'application.object.*',
        'ext.auth.VAuth',
        'ext.misc.formatter.VFormatter',
        'application.ticketing.components.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'aaaddd',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),       
        // uncomment the following to enable URLs in path-format
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                'login'=>'site/login',
                'register'=>'site/register',
                'homePage'=>'front/homePage',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                'class'=>'CFileLogRoute',
                'levels'=>'info, vardump, error',
                // 'categories'=>"ezy",
                'logFile'=>'logging.log'.date('d-m-y'),
            ),             
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
        'input' => array(
            'class' => 'CmsInput',
            'cleanPost' => false,
            'cleanGet' => false,
        ),
    // ===============
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'sessionTimeoutSeconds' => 3600, // in second (60 minutes)
        'adminEmail' => 'webmaster@example.com',
        //'ldap_host' => constant("LdapHost"),
        //'ldap_port' => constant("LdapPort"),
        //'ldap_domain' => constant("LdapDomain"),
        //'ldap_dn' => constant("LdapDN"),
    ),
);

return $config;
