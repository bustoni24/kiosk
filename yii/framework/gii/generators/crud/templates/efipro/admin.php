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
<div class="col-sm-12">

<div class="x_title">
	<h2>Table <?php echo $this->modelClass ?> View</h2>
	<div class="clearfix"></div>
</div>
<div class="row">   
<?php echo "<?php\n"; ?>
	$this->subMenu(array(
	array('label'=>'Tambah <?php echo $this->modelClass ?>', 'url'=>'<?php echo lcfirst(trim($this->modelClass)); ?>/create', 'icon'=>'fa-plus-circle', array('class' => 'btn btn-outline-warning')),
	));
	?>  
</div>

	<div class="card-box table-responsive">

	<div class="row">
		<div class="col-sm-6 pl-0 mb-0">
			<div class="dataTables_length"><label>Display <select name="<?php echo $this->modelClass ?>[display]" aria-controls="datatable-keytable" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> records</label>
			</div>
		</div>
		<div class="col-sm-6 pull-right text-right pr-0 mb-0">
			<div class="dataTables_filter"><label>Search:<input type="search" name="<?php echo $this->modelClass ?>[filter]" class="form-control input-sm" placeholder="Ketik ID, nama" aria-controls="datatable-keytable"></label></div>
		</div>
	</div>

		<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
		'dataProvider'=>$model->search(),
		'filter'=>null,
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
