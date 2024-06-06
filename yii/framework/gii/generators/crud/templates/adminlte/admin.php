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
'Manage',
);\n";
?>
?>
<div class="col-12">

<div class="card">
	<div class="card-header">
		<h2 class="card-title">Table <?php echo $this->modelClass ?> View</h2>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h3 class="card-title">
		<?php echo "<?php\n"; ?>
		$this->subMenu(array(
		array('label'=>'Tambah <?php echo $this->modelClass ?>', 'url'=>'<?php echo lcfirst(trim($this->modelClass)); ?>/create', 'icon'=>'fas fa-plus-circle', array('class' => 'btn btn-block btn-outline-success')),
		));
		?>  	
		</h3>

		<div class="card-tools">
			<div class="row">
			<div class="input-group input-group-sm" style="width: 250px;padding:10px;">
				<label class="row" style="align-items: center;">Display <select name="<?php echo $this->modelClass ?>[display]" aria-controls="datatable-keytable" class="form-control input-sm" style="width: 80px;margin-left:10px;margin-right:10px;"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> records</label>
			</div>
			
			<div class="input-group input-group-sm" style="width: 300px;padding:10px;">
				<label class="row" style="align-items: center;">Search:<input type="search" name="<?php echo $this->modelClass ?>[filter]" class="form-control input-sm" placeholder="Ketik ID, nama" aria-controls="datatable-keytable" style="width: 200px;margin-left:10px;margin-right:10px;"></label>
			</div>
			</div>
		</div>

	</div>

	<div class="clearfix"></div>

		<div class="card-body table-responsive p-0">

			<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
			'dataProvider'=>$model->search(),
			'filter'=>null,
			'itemsCssClass'=>'table table-bordered table-head-fixed text-nowrap',
			'columns'=>array(
				<?php
				$count=0;
				foreach($this->tableSchema->columns as $column)
				{
					if(++$count==7)
						echo "\t\t/*\n";
						echo "\t\t'".$column->name."',\n";
				}
					if($count>=7)
						echo "\t\t*/\n";
				?>
				array(
				'class'=>'CButtonColumn',
				),
				),
				)); ?>

		</div>
	</div>
</div>