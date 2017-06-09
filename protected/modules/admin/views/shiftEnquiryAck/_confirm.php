<?php
/* @var $this ShiftEnquiryAckController */
/* @var $model ShiftEnquiryAck */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shift-enquiry-ack-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'availability_confirmed_by_staff'); ?>
		<?php echo $form->dropDownList($model,'availability_confirmed_by_staff',array("Y"=>"Yes", "N"=>"No")); ?>
		<?php echo $form->error($model,'availability_confirmed_by_staff'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'availability_confirmed_via'); ?>
		<?php echo $form->dropDownList($model,'availability_confirmed_via',array("By email"=>"By email", "By phone"=>"By phone")); ?>
		<?php echo $form->error($model,'availability_confirmed_via'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->