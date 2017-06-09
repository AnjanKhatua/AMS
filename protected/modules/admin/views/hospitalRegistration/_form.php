<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hospital-registration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'hospital_name'); ?>
		<?php echo $form->textField($model,'hospital_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'hospital_name'); ?>
		<br /><span id="hospital_group_name_err" class="errorMessage"></span>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hospital_status'); ?>
		<?php echo $form->dropDownList($model,'hospital_status',array("A"=>"Active", "I"=>"Inactive", "S"=>"Suspended")); ?>
		<?php echo $form->error($model,'hospital_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->