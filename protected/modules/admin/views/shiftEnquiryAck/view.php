<?php
/* @var $this ShiftEnquiryAckController */
/* @var $model ShiftEnquiryAck */

//$this->breadcrumbs=array(
//	'Shift Enquiry Acks'=>array('index'),
//	$model->enquiry_id,
//);

$this->menu=array(
//	array('label'=>'List ShiftEnquiryAck', 'url'=>array('index')),
//	array('label'=>'Create ShiftEnquiryAck', 'url'=>array('create')),
//	array('label'=>'Update ShiftEnquiryAck', 'url'=>array('update', 'id'=>$model->enquiry_id)),
//	array('label'=>'Delete ShiftEnquiryAck', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->enquiry_id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage ShiftEnquiryAck', 'url'=>array('admin')),
                    array('label'=>'Booking Management For Hospitals', 'url'=>array('shiftManagementForHospital/booking', 'id'=>$model->staff_request_id)),
);
?>

<h1>View Shift Enquiry #<?php echo $model->enquiry_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'enquiry_id',
//		'staff_request_id',
//		'staff_id',
//		'enquired_by',
		'availability_confirmed_by_staff',
		'availability_confirmed_via',
		'confirmed_by',
//		'agent_user_id',
//		'is_confirmed',
	),
)); ?>
