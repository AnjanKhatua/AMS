<?php
/* @var $this ShiftEnquiryAckController */
/* @var $model ShiftEnquiryAck */

//$this->breadcrumbs=array(
//	'Shift Enquiry Acks'=>array('index'),
//	$model->enquiry_id=>array('view','id'=>$model->enquiry_id),
//	'Update',
//);

$this->menu=array(
//	array('label'=>'List ShiftEnquiryAck', 'url'=>array('index')),
//	array('label'=>'Create ShiftEnquiryAck', 'url'=>array('create')),
//	array('label'=>'View ShiftEnquiryAck', 'url'=>array('view', 'id'=>$model->enquiry_id)),
//	array('label'=>'Manage ShiftEnquiryAck', 'url'=>array('admin')),
                    array('label'=>'Booking Management For Hospitals', 'url'=>array('shiftManagementForHospital/booking', 'id'=>$model->staff_request_id)),

);
?>

<h1>Update Shift Enquiry <?php echo $model->enquiry_id; ?></h1>

<?php $this->renderPartial('_confirm', array('model'=>$model)); ?>