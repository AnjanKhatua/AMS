<?php
/* @var $this ShiftEnquiryController */
/* @var $data ShiftEnquiry */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('enquiry_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->enquiry_id), array('view', 'id'=>$data->enquiry_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_request_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_request_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enquired_by')); ?>:</b>
	<?php echo CHtml::encode($data->enquired_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('availability_confirmed_by_staff')); ?>:</b>
	<?php echo CHtml::encode($data->availability_confirmed_by_staff); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('availability_confirmed_via')); ?>:</b>
	<?php echo CHtml::encode($data->availability_confirmed_via); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirmed_by')); ?>:</b>
	<?php echo CHtml::encode($data->confirmed_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->agent_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_confirmed')); ?>:</b>
	<?php echo CHtml::encode($data->is_confirmed); ?>
	<br />

	*/ ?>

</div>