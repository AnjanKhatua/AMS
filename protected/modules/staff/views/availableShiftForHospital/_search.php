<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $model AvailableShiftForHospital */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'staff_request_id'); ?>
		<?php echo $form->textField($model,'staff_request_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hospital_unit_id'); ?>
		<?php echo $form->textField($model,'hospital_unit_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ward_id'); ?>
		<?php echo $form->textField($model,'ward_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'job_type_id'); ?>
		<?php echo $form->textField($model,'job_type_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity_confirmed'); ?>
		<?php echo $form->textField($model,'quantity_confirmed',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shift_start_datetime'); ?>
		<?php echo $form->textField($model,'shift_start_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shift_end_datetime'); ?>
		<?php echo $form->textField($model,'shift_end_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requested_date'); ?>
		<?php echo $form->textField($model,'requested_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requested_time'); ?>
		<?php echo $form->textField($model,'requested_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requested_person'); ?>
		<?php echo $form->textField($model,'requested_person',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'request_accepted_by'); ?>
		<?php echo $form->textField($model,'request_accepted_by',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requested_person_mobile_number'); ?>
		<?php echo $form->textField($model,'requested_person_mobile_number',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->