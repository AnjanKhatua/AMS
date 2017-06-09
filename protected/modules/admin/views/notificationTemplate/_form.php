<?php
/* @var $this NotificationTemplateController */
/* @var $model NotificationTemplate */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notification-template-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
                    <?php 
                    if ($model->name == ""){
                        ?>
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
                    <?php
                    }
                    ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textArea($model,'subject',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_body'); ?>
		<?php echo $form->textArea($model,'sms_body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'sms_body'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sender_email'); ?>
		<?php echo $form->textField($model,'sender_email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sender_email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->