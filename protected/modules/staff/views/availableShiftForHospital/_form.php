<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $model AvailableShiftForHospital */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'available-shift-for-hospital-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'hospital_unit_id'); ?>
		<?php echo $form->textField($model,'hospital_unit_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'hospital_unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ward_id'); ?>
		<?php echo $form->textField($model,'ward_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'ward_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'job_type_id'); ?>
		<?php echo $form->textField($model,'job_type_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'job_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity_confirmed'); ?>
		<?php echo $form->textField($model,'quantity_confirmed',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'quantity_confirmed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift_start_datetime'); ?>
		<?php echo $form->textField($model,'shift_start_datetime'); ?>
		<?php echo $form->error($model,'shift_start_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shift_end_datetime'); ?>
		<?php echo $form->textField($model,'shift_end_datetime'); ?>
		<?php echo $form->error($model,'shift_end_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_date'); ?>
		<?php echo $form->textField($model,'requested_date'); ?>
		<?php echo $form->error($model,'requested_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_time'); ?>
		<?php echo $form->textField($model,'requested_time'); ?>
		<?php echo $form->error($model,'requested_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_person'); ?>
		<?php echo $form->textField($model,'requested_person',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requested_person'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'request_accepted_by'); ?>
		<?php echo $form->textField($model,'request_accepted_by',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'request_accepted_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_person_mobile_number'); ?>
		<?php echo $form->textField($model,'requested_person_mobile_number',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'requested_person_mobile_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->