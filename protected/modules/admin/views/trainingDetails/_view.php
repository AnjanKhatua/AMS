<?php
/* @var $this TrainingDetailsController */
/* @var $data TrainingDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('training_id')); ?>:</b>
	<?php echo CHtml::encode($data->training_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fees_paid_date')); ?>:</b>
	<?php echo CHtml::encode($data->fees_paid_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fees')); ?>:</b>
	<?php echo CHtml::encode($data->fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deduction_amount')); ?>:</b>
	<?php echo CHtml::encode($data->deduction_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remaining_amount')); ?>:</b>
	<?php echo CHtml::encode($data->remaining_amount); ?>
	<br />


</div>