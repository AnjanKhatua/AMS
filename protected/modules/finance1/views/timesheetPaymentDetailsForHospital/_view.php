<?php
/* @var $this TimesheetPaymentDetailsForHospitalController */
/* @var $data TimesheetPaymentDetailsForHospital */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('week_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->week_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_amount')); ?>:</b>
	<?php echo CHtml::encode($data->total_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_amount')); ?>:</b>
	<?php echo CHtml::encode($data->payment_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remaining_amount')); ?>:</b>
	<?php echo CHtml::encode($data->remaining_amount); ?>
	<br />


</div>