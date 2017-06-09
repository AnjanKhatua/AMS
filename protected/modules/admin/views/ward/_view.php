<?php
/* @var $this WardController */
/* @var $data Ward */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ward_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ward_id), array('view', 'id'=>$data->ward_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ward_name')); ?>:</b>
	<?php echo CHtml::encode($data->ward_name); ?>
	<br />


</div>