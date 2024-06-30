<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Create',
);\n";
?>
?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Create <?php echo $this->modelClass; ?></h2>
			<div class="clearfix"></div>
		</div>
		
		<div class="x_content">

			<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>

		</div>
	</div>
</div>