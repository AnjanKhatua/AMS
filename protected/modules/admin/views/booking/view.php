<?php
/* @var $this BookingController */
/* @var $model Booking */

//$this->breadcrumbs=array(
//	'Bookings'=>array('index'),
//	$model->booking_id,
//);

$this->menu=array(
//	array('label'=>'List Booking', 'url'=>array('index')),
//	array('label'=>'Create Booking', 'url'=>array('create')),
//	array('label'=>'Update Booking', 'url'=>array('update', 'id'=>$model->booking_id)),
//	array('label'=>'Delete Booking', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->booking_id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Booking', 'url'=>array('admin')),
                    array('label'=>'Booking Management For Hospitals', 'url'=>array('shiftManagementForHospital/booking', 'id'=>$model->staff_request_id)),

);
?>

<h1>View Booking #<?php echo $model->booking_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'booking_id',
//		'staff_request_id',
//		'staff_id',
//		'confirmation_date',
//		'confirmation_time',
		'confirm_by_whom',
		'cancellation_date',
		'cancellation_time',
//		'cancel_by_whom',
		'cancel_requested_by',
	),
)); ?>
