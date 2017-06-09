<?php
/* @var $this BookingController */
/* @var $data Booking */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('booking_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->booking_id), array('view', 'id'=>$data->booking_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_request_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_request_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirmation_date')); ?>:</b>
	<?php echo CHtml::encode($data->confirmation_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirmation_time')); ?>:</b>
	<?php echo CHtml::encode($data->confirmation_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirm_by_whom')); ?>:</b>
	<?php echo CHtml::encode($data->confirm_by_whom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cancellation_date')); ?>:</b>
	<?php echo CHtml::encode($data->cancellation_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cancellation_time')); ?>:</b>
	<?php echo CHtml::encode($data->cancellation_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cancel_by_whom')); ?>:</b>
	<?php echo CHtml::encode($data->cancel_by_whom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cancel_requested_by')); ?>:</b>
	<?php echo CHtml::encode($data->cancel_requested_by); ?>
	<br />

	*/ ?>

</div>