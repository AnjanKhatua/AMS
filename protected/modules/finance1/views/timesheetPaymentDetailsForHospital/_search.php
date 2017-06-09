<?php
/* @var $this TimesheetPaymentDetailsForHospitalController */
/* @var $model TimesheetPaymentDetailsForHospital */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hospital_unit_id'); ?>
		<?php echo $form->textField($model,'hospital_unit_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'week_end_date'); ?>
		<?php echo $form->textField($model,'week_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_amount'); ?>
		<?php echo $form->textField($model,'total_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_amount'); ?>
		<?php echo $form->textField($model,'payment_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'remaining_amount'); ?>
		<?php echo $form->textField($model,'remaining_amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->