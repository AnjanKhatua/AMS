<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $data AvailableShiftForHospital */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_request_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->staff_request_id), array('view', 'id'=>$data->staff_request_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ward_id')); ?>:</b>
	<?php echo CHtml::encode($data->ward_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->job_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_confirmed')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_confirmed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_start_datetime')); ?>:</b>
	<?php echo CHtml::encode(Utility::changeDateToUK($data->shift_start_datetime)); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_end_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->shift_end_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_date')); ?>:</b>
	<?php echo CHtml::encode($data->requested_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_time')); ?>:</b>
	<?php echo CHtml::encode($data->requested_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_person')); ?>:</b>
	<?php echo CHtml::encode($data->requested_person); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_accepted_by')); ?>:</b>
	<?php echo CHtml::encode($data->request_accepted_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_person_mobile_number')); ?>:</b>
	<?php echo CHtml::encode($data->requested_person_mobile_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>