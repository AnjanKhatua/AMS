<?php
/* @var $this NotificationLogController */
/* @var $model NotificationLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notification-log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'notification_type'); ?>
		<?php echo $form->textField($model,'notification_type',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'notification_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'send_to'); ?>
		<?php echo $form->textField($model,'send_to',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'send_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'send_from'); ?>
		<?php echo $form->textField($model,'send_from',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'send_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notification_sub'); ?>
		<?php echo $form->textArea($model,'notification_sub',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notification_sub'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notification_body'); ?>
		<?php echo $form->textArea($model,'notification_body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notification_body'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'send_datetime'); ?>
		<?php echo $form->textField($model,'send_datetime'); ?>
		<?php echo $form->error($model,'send_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'ip'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->