<?php
/* @var $this UploadedTimesheetByStaffController */
/* @var $data UploadedTimesheetByStaff */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
	<?php echo CHtml::encode($data->ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('week_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->week_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upload_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->upload_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timesheet_name')); ?>:</b>
	<?php echo CHtml::encode($data->timesheet_name); ?>
	<br />


</div>