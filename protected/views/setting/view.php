<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	'Settings'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Setting', 'url'=>array('index')),
	array('label'=>'Create Setting', 'url'=>array('create')),
	array('label'=>'Update Setting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Setting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Setting', 'url'=>array('admin')),
);
?>
<div class="col-12">
<div class="card card-info">
	<div class="card-header">
	<h3 class="card-title">View Setting #<?php echo $model->id; ?></h3>
	</div>

	<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
				'id',
		'name',
		'keterangan',
		'value',
			),
	)); ?>

<div class="card-footer float-right">
	<a href="<?= Constant::baseUrl() . '/setting/' ?>" class="btn btn-outline-warning resetBtn"><i class="fa fa-reply"></i> Kembali</a>
</div>
</div>
</div>