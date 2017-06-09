<?php
/* @var $this StaffHolidayController */
/* @var $data StaffHoliday */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('holiday_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->holiday_id), array('view', 'id'=>$data->holiday_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
                    <?php echo CHtml::encode(Utility::changeDateToUK($data->start_date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode(Utility::changeDateToUK($data->end_date)); ?>
	<br />


</div>