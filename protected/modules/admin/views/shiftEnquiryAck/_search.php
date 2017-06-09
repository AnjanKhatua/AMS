<?php
/* @var $this ShiftEnquiryAckController */
/* @var $model ShiftEnquiryAck */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'enquiry_id'); ?>
		<?php echo $form->textField($model,'enquiry_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'staff_request_id'); ?>
		<?php echo $form->textField($model,'staff_request_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'enquired_by'); ?>
		<?php echo $form->textField($model,'enquired_by',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'availability_confirmed_by_staff'); ?>
		<?php echo $form->textField($model,'availability_confirmed_by_staff',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'availability_confirmed_via'); ?>
		<?php echo $form->textField($model,'availability_confirmed_via',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'confirmed_by'); ?>
		<?php echo $form->textField($model,'confirmed_by',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'agent_user_id'); ?>
		<?php echo $form->textField($model,'agent_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_confirmed'); ?>
		<?php echo $form->textField($model,'is_confirmed',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->