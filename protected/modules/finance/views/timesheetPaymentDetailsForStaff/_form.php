<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'timesheet-payment-details-for-staff-form',
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
		<?php echo $form->labelEx($model,'invoice_date'); ?>
		<?php echo $form->textField($model,'invoice_date'); ?>
		<?php echo $form->error($model,'invoice_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'week_end_date'); ?>
		<?php echo $form->textField($model,'week_end_date'); ?>
		<?php echo $form->error($model,'week_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_amount'); ?>
		<?php echo $form->textField($model,'total_amount'); ?>
		<?php echo $form->error($model,'total_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'training_deduction_amount'); ?>
		<?php echo $form->textField($model,'training_deduction_amount'); ?>
		<?php echo $form->error($model,'training_deduction_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'net_amount'); ?>
		<?php echo $form->textField($model,'net_amount'); ?>
		<?php echo $form->error($model,'net_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'training_deduction_apply'); ?>
		<?php echo $form->textField($model,'training_deduction_apply',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'training_deduction_apply'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid_status'); ?>
		<?php echo $form->textField($model,'paid_status',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'paid_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->