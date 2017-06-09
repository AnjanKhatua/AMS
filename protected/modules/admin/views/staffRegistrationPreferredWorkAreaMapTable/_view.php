<?php
/* @var $this StaffRegistrationPreferredWorkAreaMapTableController */
/* @var $data StaffRegistrationPreferredWorkAreaMapTable */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_area_id')); ?>:</b>
	<?php echo CHtml::encode($data->work_area_id); ?>
	<br />


</div>