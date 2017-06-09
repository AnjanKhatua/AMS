<?php
/* @var $this HospitalJobTypeRateController */
/* @var $data HospitalJobTypeRate */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finance_job_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->finance_job_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate')); ?>:</b>
	<?php echo CHtml::encode($data->rate); ?>
	<br />
        
                  <b><?php echo CHtml::encode($data->getAttributeLabel('pay_rate_for_staffs')); ?>:</b>
	<?php echo CHtml::encode($data->pay_rate_for_staffs); ?>
	<br />


</div>