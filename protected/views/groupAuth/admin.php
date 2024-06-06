<?php
/* @var $this GroupAuthController */
/* @var $model GroupAuth */

$this->breadcrumbs=array(
	'Group Auths'=>array('index'),
	'Manage',
);

$this->menuTab(array(
	array('label'=>'List GroupAuth', 'url'=>'groupAuth/admin', 'icon' => 'fa-list-ul'),
));

?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="pull-right text-right">   
			<?php
			$this->subMenu(array(
				array('label'=>'Refresh', 'url'=>'', 'icon'=>'fa-refresh', array('class' => 'btn btn-success', 'id'=>'btn-refresh')),
				array('label'=>'Tambah', 'url'=>'groupAuth/create', 'icon'=>'fa-plus-circle', array('class' => 'btn btn-info')),
			));
			?>   
		</div>
		<div class="x_title">
			<h2>Data GroupAuth</h2>
			<div class="clearfix"></div>
		</div>
		
		<div class="x_content">
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'group-auth-grid',
							'dataProvider'=>$model->search(),
							'filter'=>$model,
							'columns'=>array(
								'id',
								'className',
								'action',
								[
									'name' => 'group_id',
									'value' => function ($data) {
										return isset($data->level) ? $data->level->nama : '-';
									}
								],
								array(
									'class'=>'CButtonColumn',
								),
							),
						)); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#btn-refresh').on('click', function(){
		$("#group-auth-grid").yiiGridView("update", {});
	});
</script>