<?php
/* @var $this HospitalRegistrationController */
/* @var $data HospitalRegistration */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->hospital_id), array('view', 'id'=>$data->hospital_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_name')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_status')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_status); ?>
	<br />


</div>