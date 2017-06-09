<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $selectedDate = "";
    $selectedStaff = "";
    ?>
    
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
                                    <?php
                                    $la_allStaff = User::model()->staffAll();
                                    $selectedStaff = $model->staff_id;
                                    ?>
                                    <?php echo CHtml::dropDownList('TimesheetPaymentDetailsForStaff[staff_id]', $selectedStaff, $la_allStaff, array('single' => 'single', 'class' => 'hospital_unit_id')); ?>
		<?php // echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'week_end_date'); ?>
                                    <?php
                                    $allDate = Utility::getWeekDate();
                                    $selectedDate = $model->week_end_date;
                                    ?>                                        
                                    <?php echo CHtml::dropDownList('TimesheetPaymentDetailsForStaff[week_end_date]', $selectedDate, $allDate, array('single' => 'single')); ?>
                                    <?php // echo $form->textField($model,'week_end_date');  ?>
                                    <?php echo $form->error($model, 'week_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_amount'); ?>
		<?php echo $form->textField($model,'total_amount'); ?>
		<?php echo $form->error($model,'total_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'for_training_deduction'); ?>
		<?php echo $form->textField($model,'for_training_deduction'); ?>
		<?php echo $form->error($model,'for_training_deduction'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_amount'); ?>
		<?php echo $form->textField($model,'payment_amount'); ?>
		<?php echo $form->error($model,'payment_amount'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'remaining_amount'); ?>
		<?php // echo $form->textField($model,'remaining_amount'); ?>
		<?php // echo $form->error($model,'remaining_amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->