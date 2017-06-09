<?php
/* @var $this WardHospitalUnitMapController */
/* @var $data WardHospitalUnitMap */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ward_id')); ?>:</b>
	<?php echo CHtml::encode($data->ward_id); ?>
	<br />


</div>