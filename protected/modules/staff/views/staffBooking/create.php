<?php
/* @var $this StaffBookingController */
/* @var $model StaffBooking */

$this->breadcrumbs=array(
	'Staff Bookings'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Staff Booking', 'url'=>array('index')),
	array('label'=>'Upcoming Confirmed Shifts', 'url'=>array('admin')),
                    array('label'=>'Previous Confirmed Shifts', 'url'=>array('adminPrevious')),
);
?>

<h1>Create Staff Booking</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>