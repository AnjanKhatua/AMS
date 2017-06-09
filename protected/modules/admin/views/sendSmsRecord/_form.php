<?php
/* @var $this SendSmsRecordController */
/* @var $model SendSmsRecord */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'send-sms-record-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sender_number'); ?>
		<?php echo $form->textField($model,'sender_number',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'sender_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receiver_number'); ?>
		<?php echo $form->textField($model,'receiver_number',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'receiver_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datetime'); ?>
		<?php echo $form->textField($model,'datetime'); ?>
		<?php echo $form->error($model,'datetime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->