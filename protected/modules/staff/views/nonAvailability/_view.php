<?php
/* @var $this NonAvailabilityController */
/* @var $data NonAvailability */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('non_availablility_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->non_availablility_id), array('view', 'id'=>$data->non_availablility_id)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
	<?php echo CHtml::encode($data->start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_time')); ?>:</b>
	<?php echo CHtml::encode($data->end_time); ?>
	<br />


</div>