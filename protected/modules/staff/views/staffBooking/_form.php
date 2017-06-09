<?php
/* @var $this StaffBookingController */
/* @var $model StaffBooking */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-booking-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_request_id'); ?>
		<?php echo $form->textField($model,'staff_request_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'staff_request_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'confirmation_date'); ?>
		<?php echo $form->textField($model,'confirmation_date'); ?>
		<?php echo $form->error($model,'confirmation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'confirmation_time'); ?>
		<?php echo $form->textField($model,'confirmation_time'); ?>
		<?php echo $form->error($model,'confirmation_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'confirm_by_whom'); ?>
		<?php echo $form->textField($model,'confirm_by_whom',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'confirm_by_whom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cancellation_date'); ?>
		<?php echo $form->textField($model,'cancellation_date'); ?>
		<?php echo $form->error($model,'cancellation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cancellation_time'); ?>
		<?php echo $form->textField($model,'cancellation_time'); ?>
		<?php echo $form->error($model,'cancellation_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cancel_by_whom'); ?>
		<?php echo $form->textField($model,'cancel_by_whom',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'cancel_by_whom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cancel_requested_by'); ?>
		<?php echo $form->textField($model,'cancel_requested_by',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'cancel_requested_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->