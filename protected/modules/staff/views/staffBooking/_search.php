<?php
/* @var $this StaffBookingController */
/* @var $model StaffBooking */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'booking_id'); ?>
		<?php echo $form->textField($model,'booking_id',array('size'=>11,'maxlength'=>11)); ?>
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
		<?php echo $form->label($model,'shift_start_datetime'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'confirmation_date'); ?>
		<?php echo $form->textField($model,'confirmation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'confirmation_time'); ?>
		<?php echo $form->textField($model,'confirmation_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'confirm_by_whom'); ?>
		<?php echo $form->textField($model,'confirm_by_whom',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cancellation_date'); ?>
		<?php echo $form->textField($model,'cancellation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cancellation_time'); ?>
		<?php echo $form->textField($model,'cancellation_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cancel_by_whom'); ?>
		<?php echo $form->textField($model,'cancel_by_whom',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cancel_requested_by'); ?>
		<?php echo $form->textField($model,'cancel_requested_by',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->