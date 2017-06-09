<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $data TimesheetPaymentDetailsForStaff */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_amount')); ?>:</b>
	<?php echo CHtml::encode($data->total_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('training_deduction_amount')); ?>:</b>
	<?php echo CHtml::encode($data->training_deduction_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_amount')); ?>:</b>
	<?php echo CHtml::encode($data->net_amount); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('training_deduction_apply')); ?>:</b>
	<?php echo CHtml::encode($data->training_deduction_apply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid_status')); ?>:</b>
	<?php echo CHtml::encode($data->paid_status); ?>
	<br />

	*/ ?>

</div>