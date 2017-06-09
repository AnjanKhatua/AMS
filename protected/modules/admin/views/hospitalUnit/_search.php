<?php
/* @var $this HospitalUnitController */
/* @var $model HospitalUnit */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<!--<div class="row">
		<?php //echo $form->label($model,'hospital_unit_id'); ?>
		<?php //echo $form->textField($model,'hospital_unit_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'hospital_id'); ?>
		<?php echo $form->textField($model,'hospital_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hospital_unit'); ?>
		<?php echo $form->textField($model,'hospital_unit',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'local_area_id'); ?>
		<?php echo $form->textField($model,'local_area_id',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hospital_email'); ?>
		<?php echo $form->textField($model,'hospital_email',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_number'); ?>
		<?php echo $form->textField($model,'contact_number',array('size'=>10,'maxlength'=>10)); ?>
	</div>
        
                    <div class="row">
		<?php echo $form->label($model,'relevant_coordinator_id'); ?>
		<?php echo $form->textField($model,'relevant_coordinator_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hospital_unit_active_status'); ?>
		<?php echo $form->textField($model,'hospital_unit_active_status',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->