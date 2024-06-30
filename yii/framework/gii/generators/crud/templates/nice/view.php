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
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>
?>

<div class="card mb-3">
	<div class="card-body">

		<h1>Lihat Data <?php echo $this->modelClass." #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

		<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
		<?php
		foreach($this->tableSchema->columns as $column)
			echo "\t\t'".$column->name."',\n";
		?>
			),
		)); ?>

		<a class="btn btn-secondary mb-3 mt-3 float-end" href="#" onclick="window.history.go(-1); return false;">Kembali</a>
	</div>
</div>
