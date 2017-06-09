<?php
/* @var $this JobTypeController */
/* @var $data JobType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->job_type_id), array('view', 'id'=>$data->job_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_type')); ?>:</b>
	<?php echo CHtml::encode($data->job_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('job_type_active_status')); ?>:</b>
	<?php echo CHtml::encode($data->job_type_active_status); ?>
	<br />


</div>