<?php
/* @var $this StaffBookingController */
/* @var $model StaffBooking */

$this->breadcrumbs=array(
	'Staff Bookings'=>array('index'),
	$model->booking_id=>array('view','id'=>$model->booking_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Staff Booking', 'url'=>array('index')),
//	array('label'=>'Create Staff Booking', 'url'=>array('create')),
//	array('label'=>'View Staff Booking', 'url'=>array('view', 'id'=>$model->booking_id)),
	array('label'=>'Upcoming Confirmed Shifts', 'url'=>array('admin')),
                    array('label'=>'Previous Confirmed Shifts', 'url'=>array('adminPrevious')),);
?>

<h1>Update Staff Booking <?php echo $model->booking_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>