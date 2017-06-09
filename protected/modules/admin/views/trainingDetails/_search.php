<?php
/* @var $this TrainingDetailsController */
/* @var $model TrainingDetails */
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
		<?php echo $form->label($model,'training_id'); ?>
		<?php echo $form->textField($model,'training_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fees_paid_date'); ?>
		<?php echo $form->textField($model,'fees_paid_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fees'); ?>
		<?php echo $form->textField($model,'fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deduction_amount'); ?>
		<?php echo $form->textField($model,'deduction_amount',array('size'=>3,'maxlength'=>3)); ?>
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