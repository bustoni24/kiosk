<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs=array(
'Menus'=>array('index'),
'Manage',
);

?>

<h1>Manage Menus</h1>

<div class="pull-right text-right">   
	<?php
	$this->subMenu(array(
	array('label'=>'Refresh', 'url'=>'', 'icon'=>'fa-refresh', array('class' => 'btn btn-success', 'id'=>'btn-refresh')),
	array('label'=>'Tambah', 'url'=>'menu/create', 'icon'=>'fa-plus-circle', array('class' => 'btn btn-info')),
	));
	?>  
</div>
<div class="x_title">
	<h2>Data Menu</h2>
	<div class="clearfix"></div>
</div>


<div class="col-sm-12">
	<div class="card-box table-responsive">

		<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'menu-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
		'id',
		[
            'header' => 'Jenis Pengguna',
            'name' => 'level_akses',
            'value' => function($data) {
                return (isset($data->level) ? $data->level->nama : '-');
            },
        ],
		'label',
		'url',
		'position',
		'icon',
			array(
			'class'=>'CButtonColumn',
			),
			),
			)); ?>

		</div>
	</div>
