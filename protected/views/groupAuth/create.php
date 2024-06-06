<?php
/* @var $this GroupAuthController */
/* @var $model GroupAuth */

$this->breadcrumbs=array(
	'Group Auths'=>array('index'),
	'Create',
);
?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="pull-right text-right">   
			<a class="btn btn-info" href="<?php echo Constant::baseUrl().'/groupAuth'; ?>/admin">Manage</a>   
		</div>
		<div class="x_title">
			<h2>Create<small>GroupAuth</small></h2>
			<div class="clearfix"></div>
		</div>
		
		<div class="x_content">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>
