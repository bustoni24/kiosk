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
<div class="card mb-3">
	<div class="card-body">

	<h1 class="p-v-15">Kelola Data <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

	<div class="col-12 text-end">   
		<?php echo "<?php\n"; ?>
		$this->subMenu(array(
		array('label'=>'Refresh', 'url'=>'', 'icon'=>'bi bi-arrow-repeat', array('class' => 'btn btn-success', 'id'=>'btn-refresh', 'style' => 'margin-right:10px;')),
		array('label'=>'Tambah', 'url'=>'<?php echo lcfirst(trim($this->modelClass)); ?>/create', 'icon'=>'bi bi-plus-circle', array('class' => 'btn btn-info')),
		));
		?>  
	</div>

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
					'htmlOptions' => ['style' => 'width: 90px;']
				),
			),
		)); ?>

	</div>
</div>