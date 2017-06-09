<?php
/* @var $this ShiftEnquiryAckController */
/* @var $model ShiftEnquiryAck */

$this->breadcrumbs=array(
	'Shift Enquiry Acks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShiftEnquiryAck', 'url'=>array('index')),
	array('label'=>'Manage ShiftEnquiryAck', 'url'=>array('admin')),
);
?>

<h1>Create ShiftEnquiryAck</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>