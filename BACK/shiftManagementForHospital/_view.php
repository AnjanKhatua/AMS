<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $data ShiftManagementForHospital */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_request_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->staff_request_id), array('view', 'id'=>$data->staff_request_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->job_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_start_time')); ?>:</b>
	<?php echo CHtml::encode($data->shift_start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_end_time')); ?>:</b>
	<?php echo CHtml::encode($data->shift_end_time); ?>
	<br />

	<?php /*
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

	*/ ?>

</div>