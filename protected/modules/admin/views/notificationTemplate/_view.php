<?php
/* @var $this NotificationTemplateController */
/* @var $data NotificationTemplate */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('body')); ?>:</b>
	<?php echo CHtml::encode($data->body); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_body')); ?>:</b>
	<?php echo CHtml::encode($data->sms_body); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_email')); ?>:</b>
	<?php echo CHtml::encode($data->sender_email); ?>
	<br />


</div>