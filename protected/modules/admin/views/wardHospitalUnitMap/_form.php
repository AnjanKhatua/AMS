<?php
/* @var $this WardHospitalUnitMapController */
/* @var $model WardHospitalUnitMap */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ward-hospital-unit-map-form',
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
		<?php echo $form->textField($model,'ward_id',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'ward_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->