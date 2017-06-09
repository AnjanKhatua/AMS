<?php
/* @var $this SendSmsRecordController */
/* @var $data SendSmsRecord */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_number')); ?>:</b>
	<?php echo CHtml::encode($data->sender_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receiver_number')); ?>:</b>
	<?php echo CHtml::encode($data->receiver_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datetime')); ?>:</b>
	<?php echo CHtml::encode($data->datetime); ?>
	<br />


</div>