<?php
/* @var $this StaffBookingController */
/* @var $model StaffBooking */

$this->breadcrumbs=array(
	'Staff Bookings'=>array('index'),
	$model->booking_id,
);

$this->menu=array(
//	array('label'=>'List Staff Booking', 'url'=>array('index')),
//	array('label'=>'Create Staff Booking', 'url'=>array('create')),
//	array('label'=>'Update Staff Booking', 'url'=>array('update', 'id'=>$model->booking_id)),
//	array('label'=>'Delete Staff Booking', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->booking_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Upcoming Confirmed Shifts', 'url'=>array('admin')),
                    array('label'=>'Previous Confirmed Shifts', 'url'=>array('adminPrevious')),
                    array('label'=>'Cancelled Confirmed Shifts', 'url'=>array('adminCancel')),
    );
?>

<h1>View Staff Booking</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'booking_id',
//		'staff_request_id',
//		'staff_id',
                array(
                    'name' => 'first_name',
                    'value' => $model->user->first_name,
                ),
                array(
                    'name' => 'hospital_unit_id',
                    'value' => $model->staffRequest->hospitalUnit->hospital_unit,
                ),
                array(
                    'name' => 'job_type_id',
                    'value' => $model->staffRequest->jobType->job_type,
                ),
                array(
                    'name' => 'ward_id',
                    'value' => $model->staffRequest->ward->ward_name,
                ),
                array(
                    'name' => 'shift_start_datetime',
                    'value' => Utility::changeDateToUK($model->staffRequest->shift_start_datetime),
                ),
                array(
                    'name' => 'shift_end_datetime',
                    'value' => Utility::changeDateToUK($model->staffRequest->shift_end_datetime),
                ),
//		'confirmation_date',
//		'confirmation_time',
//		'confirm_by_whom',
//		'cancellation_date',
//		'cancellation_time',
//		'cancel_by_whom',
//		'cancel_requested_by',
	),
)); ?>
