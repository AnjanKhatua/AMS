<?php
/* @var $this BookingController */
/* @var $model Booking */

//$this->breadcrumbs = array(
//    'Bookings' => array('index'),
//    $model->booking_id => array('view', 'id' => $model->booking_id),
//    'Update',
//);

$this->menu = array(
//	array('label'=>'List Booking', 'url'=>array('index')),
//	array('label'=>'Create Booking', 'url'=>array('create')),
//	array('label'=>'View Booking', 'url'=>array('view', 'id'=>$model->booking_id)),
//	array('label'=>'Manage Booking', 'url'=>array('admin')),
                    array('label' => 'Booking Management For Hospitals', 'url' => array('shiftManagementForHospital/booking', 'id' => $model->staff_request_id)),
);
?>

<h1>Update Booking <?php echo $model->booking_id; ?></h1>

<?php $this->renderPartial('_cancel', array('model' => $model)); ?>