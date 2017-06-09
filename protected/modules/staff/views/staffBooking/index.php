<?php
/* @var $this StaffBookingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Bookings',
);

$this->menu=array(
//	array('label'=>'Create Staff Booking', 'url'=>array('create')),
	array('label'=>'Upcoming Confirmed Shifts', 'url'=>array('admin')),
                    array('label'=>'Previous Confirmed Shifts', 'url'=>array('adminPrevious')),);
?>

<h1>Staff Bookings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
