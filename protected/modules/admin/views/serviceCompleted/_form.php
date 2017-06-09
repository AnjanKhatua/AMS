<?php
/* @var $this ServiceCompletedController */
/* @var $model ServiceCompleted */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'service-completed-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'enquiry_id'); ?>
		<?php echo $form->textField($model,'enquiry_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'enquiry_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hospital_unit_id'); ?>
		<?php echo $form->textField($model,'hospital_unit_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'hospital_unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'booking_id'); ?>
		<?php echo $form->textField($model,'booking_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'booking_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift_start_time'); ?>
		<?php echo $form->textField($model,'shift_start_time'); ?>
		<?php echo $form->error($model,'shift_start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift_end_time'); ?>
		<?php echo $form->textField($model,'shift_end_time'); ?>
		<?php echo $form->error($model,'shift_end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_category'); ?>
		<?php echo $form->textField($model,'staff_category',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'staff_category'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->