<?php
/* @var $this NotificationLogController */
/* @var $data NotificationLog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notification_type')); ?>:</b>
	<?php echo CHtml::encode($data->notification_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_to')); ?>:</b>
	<?php echo CHtml::encode($data->send_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_from')); ?>:</b>
	<?php echo CHtml::encode($data->send_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notification_sub')); ?>:</b>
	<?php echo CHtml::encode($data->notification_sub); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notification_body')); ?>:</b>
	<?php echo CHtml::encode($data->notification_body); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->send_datetime); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
	<?php echo CHtml::encode($data->ip); ?>
	<br />

	*/ ?>

</div>