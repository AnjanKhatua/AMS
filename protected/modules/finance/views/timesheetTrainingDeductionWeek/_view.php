<?php
/* @var $this TimesheetTrainingDeductionWeekController */
/* @var $data TimesheetTrainingDeductionWeek */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_date')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('week_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->week_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apply_status')); ?>:</b>
	<?php echo CHtml::encode($data->apply_status); ?>
	<br />


</div>