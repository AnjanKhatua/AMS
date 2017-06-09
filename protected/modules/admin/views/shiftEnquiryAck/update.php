<?php
/* @var $this ShiftEnquiryAckController */
/* @var $model ShiftEnquiryAck */

$this->breadcrumbs=array(
	'Shift Enquiry Acks'=>array('index'),
	$model->enquiry_id=>array('view','id'=>$model->enquiry_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShiftEnquiryAck', 'url'=>array('index')),
	array('label'=>'Create ShiftEnquiryAck', 'url'=>array('create')),
	array('label'=>'View ShiftEnquiryAck', 'url'=>array('view', 'id'=>$model->enquiry_id)),
	array('label'=>'Manage ShiftEnquiryAck', 'url'=>array('admin')),
);
?>

<h1>Update ShiftEnquiryAck <?php echo $model->enquiry_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>