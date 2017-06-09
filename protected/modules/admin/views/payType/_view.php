<?php
/* @var $this PayTypeController */
/* @var $data PayType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pay_type_id), array('view', 'id'=>$data->pay_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_type')); ?>:</b>
	<?php echo CHtml::encode($data->pay_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_type_active_status')); ?>:</b>
	<?php echo CHtml::encode($data->pay_type_active_status); ?>
	<br />


</div>