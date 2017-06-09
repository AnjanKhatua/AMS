<?php
/* @var $this HospitalUnitController */
/* @var $data HospitalUnit */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->hospital_unit_id), array('view', 'id'=>$data->hospital_unit_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_name')); ?>:</b>
	<?php echo CHtml::encode($data->localArea->area_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_email')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_email); ?>
	<br />
        
                    <b><?php echo CHtml::encode($data->getAttributeLabel('relevant_coordinator_id')); ?>:</b>
	<?php echo CHtml::encode($data->relevant_coordinator_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_number')); ?>:</b>
	<?php echo CHtml::encode($data->contact_number); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_active_status')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_active_status); ?>
	<br />

	*/ ?>

</div>