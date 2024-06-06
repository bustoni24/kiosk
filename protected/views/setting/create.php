<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	'Settings'=>array('index'),
	'Create',
);
?>
<div class="col-12">
<div class="card card-info">
	<div class="card-header">
	<h3 class="card-title">Create Setting</h3>
	</div>

	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>
</div>