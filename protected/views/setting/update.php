<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
'Settings'=>array('index'),
$model->name=>array('view','id'=>$model->id),
'Update',
);

?>

<div class="col-12">
<div class="card card-info">
	<div class="card-header">
	<h3 class="card-title">Update Setting <?php echo $model->id; ?></h3>
	</div>

	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>
</div>