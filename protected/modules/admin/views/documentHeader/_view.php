<?php
/* @var $this DocumentHeaderController */
/* @var $data DocumentHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_header_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->document_header_id), array('view', 'id'=>$data->document_header_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('header_name')); ?>:</b>
	<?php echo CHtml::encode($data->header_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active_status')); ?>:</b>
	<?php echo CHtml::encode($data->active_status); ?>
	<br />


</div>