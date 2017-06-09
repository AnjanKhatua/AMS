<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<!--<div class="row">
		<?php //echo $form->label($model,'hospital_id'); ?>
		<?php //echo $form->textField($model,'hospital_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'hospital_name'); ?>
		<?php echo $form->textField($model,'hospital_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hospital_status'); ?>
		<?php echo $form->textField($model,'hospital_status',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->