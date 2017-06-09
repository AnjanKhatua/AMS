<?php
/* @var $this WorkAreaController */
/* @var $data WorkArea */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_area_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->work_area_id), array('view', 'id'=>$data->work_area_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_name')); ?>:</b>
	<?php echo CHtml::encode($data->area_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_active_status')); ?>:</b>
	<?php echo CHtml::encode($data->area_active_status); ?>
	<br />


</div>