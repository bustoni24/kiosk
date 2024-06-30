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

<h1>Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

<div class="pull-right text-right">   
	<?php echo "<?php\n"; ?>
	$this->subMenu(array(
	array('label'=>'Refresh', 'url'=>'', 'icon'=>'fa-refresh', array('class' => 'btn btn-success', 'id'=>'btn-refresh')),
	array('label'=>'Tambah', 'url'=>'<?php echo lcfirst(trim($this->modelClass)); ?>/create', 'icon'=>'fa-plus-circle', array('class' => 'btn btn-info')),
	));
	?>  
</div>
<div class="x_title">
	<h2>Data <?php echo $this->modelClass; ?></h2>
	<div class="clearfix"></div>
</div>


<div class="col-sm-12">
	<div class="card-box table-responsive">

		<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
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
