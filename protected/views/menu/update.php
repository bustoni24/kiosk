<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
'Menus'=>array('index'),
$model->id=>array('view','id'=>$model->id),
'Update',
);

?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Update Menu <?php echo $model->id; ?></h2>
			<div class="clearfix"></div>
		</div>
		
		<div class="x_content">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>		</div>
	</div>
</div>