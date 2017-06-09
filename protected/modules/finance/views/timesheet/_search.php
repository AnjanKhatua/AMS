<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
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
		<?php echo $form->label($model,'finance_job_type_id'); ?>
		<?php echo $form->textField($model,'finance_job_type_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monday'); ?>
		<?php echo $form->textField($model,'monday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tuesday'); ?>
		<?php echo $form->textField($model,'tuesday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wednesday'); ?>
		<?php echo $form->textField($model,'wednesday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'thursday'); ?>
		<?php echo $form->textField($model,'thursday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'friday'); ?>
		<?php echo $form->textField($model,'friday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'saturday'); ?>
		<?php echo $form->textField($model,'saturday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sunday'); ?>
		<?php echo $form->textField($model,'sunday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_worked_hours'); ?>
		<?php echo $form->textField($model,'total_worked_hours'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exp'); ?>
		<?php echo $form->textField($model,'exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_amount_of_staff'); ?>
		<?php echo $form->textField($model,'total_amount_of_staff'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->label($model,'total_amount_of_hospital'); ?>
		<?php echo $form->textField($model,'total_amount_of_hospital'); ?>
	</div>    

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paid_to_staff'); ?>
		<?php echo $form->textField($model,'paid_to_staff',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paid_by_hospital'); ?>
		<?php echo $form->textField($model,'paid_by_hospital',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->