<?php
/* @var $this TimesheetController */
/* @var $data Timesheet */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('week_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->week_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finance_job_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->finance_job_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monday')); ?>:</b>
	<?php echo CHtml::encode($data->monday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tuesday')); ?>:</b>
	<?php echo CHtml::encode($data->tuesday); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('wednesday')); ?>:</b>
	<?php echo CHtml::encode($data->wednesday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('thursday')); ?>:</b>
	<?php echo CHtml::encode($data->thursday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('friday')); ?>:</b>
	<?php echo CHtml::encode($data->friday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('saturday')); ?>:</b>
	<?php echo CHtml::encode($data->saturday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sunday')); ?>:</b>
	<?php echo CHtml::encode($data->sunday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_worked_hours')); ?>:</b>
	<?php echo CHtml::encode($data->total_worked_hours); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exp')); ?>:</b>
	<?php echo CHtml::encode($data->exp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_amount_of_staff')); ?>:</b>
	<?php echo CHtml::encode($data->total_amount_of_staff); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_amount_of_hospital')); ?>:</b>
	<?php echo CHtml::encode($data->total_amount_of_hospital); ?>
	<br /> 

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid_to_staff')); ?>:</b>
	<?php echo CHtml::encode($data->paid_to_staff); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid_by_hospital')); ?>:</b>
	<?php echo CHtml::encode($data->paid_by_hospital); ?>
	<br />

	*/ ?>

</div>