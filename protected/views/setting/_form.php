<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'setting-form',
	'htmlOptions'=>array('class' => 'form-horizontal'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="card-body">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
		<div class="form-group row">
			<?php echo $form->labelEx($model,'name',array('class'=>'col-sm-4 col-form-label')); ?>
			<div class="col-sm-8">
					<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100,'class'=>'form-control')); ?>
					<?php echo $form->error($model,'name'); ?>
			</div>
		</div>
	
		<div class="form-group row">
			<?php echo $form->labelEx($model,'keterangan',array('class'=>'col-sm-4 col-form-label')); ?>
			<div class="col-sm-8">
					<?php echo $form->textArea($model,'keterangan',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
					<?php echo $form->error($model,'keterangan'); ?>
			</div>
		</div>
	
		<div class="form-group row">
			<?php echo $form->labelEx($model,'value',array('class'=>'col-sm-4 col-form-label')); ?>
			<div class="col-sm-8">
					<?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>256,'class'=>'form-control')); ?>
					<?php echo $form->error($model,'value'); ?>
			</div>
		</div>
	</div>

	<div class="card-footer">
		<button type="submit" class="btn btn-success float-right ml-10"><i class="fa fa-check-square-o"></i> Submit</button>
		<?php if (!isset($model->id)): ?>
			<button type="reset" class="btn btn-outline-success resetBtn float-right"><i class="fa fa-repeat"></i> Reset</button>
			<?php else: ?>
			<button type="button" onclick="history.back();" class="btn btn-outline-success resetBtn float-right"><i class="fa fa-reply"></i> Kembali</button>
		<?php endif; ?>	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->