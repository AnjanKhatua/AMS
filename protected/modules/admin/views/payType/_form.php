<?php
/* @var $this PayTypeController */
/* @var $model PayType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pay-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pay_type'); ?>
		<?php echo $form->textField($model,'pay_type',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'pay_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pay_type_active_status'); ?>
		<?php echo $form->dropDownList($model,'pay_type_active_status',array("Y"=>"Yes", "N"=>"No")); ?>
		<?php echo $form->error($model,'pay_type_active_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->