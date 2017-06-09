<?php
/* @var $this WardController */
/* @var $model Ward */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<!--<div class="row">
		<?php //echo $form->label($model,'ward_id'); ?>
		<?php //echo $form->textField($model,'ward_id',array('size'=>6,'maxlength'=>6)); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'ward_name'); ?>
		<?php echo $form->textField($model,'ward_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->