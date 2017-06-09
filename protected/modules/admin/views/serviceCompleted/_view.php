<?php
/* @var $this ServiceCompletedController */
/* @var $data ServiceCompleted */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->service_id), array('view', 'id'=>$data->service_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enquiry_id')); ?>:</b>
	<?php echo CHtml::encode($data->enquiry_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('booking_id')); ?>:</b>
	<?php echo CHtml::encode($data->booking_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_start_time')); ?>:</b>
	<?php echo CHtml::encode($data->shift_start_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_end_time')); ?>:</b>
	<?php echo CHtml::encode($data->shift_end_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_category')); ?>:</b>
	<?php echo CHtml::encode($data->staff_category); ?>
	<br />

	*/ ?>

</div>