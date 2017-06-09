<?php
/* @var $this NonAvailabilityOfStaffController */
/* @var $model NonAvailabilityOfStaff */

$this->breadcrumbs=array(
	'Non Availability Of Staff'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NonAvailabilityOfStaff', 'url'=>array('index')),
	array('label'=>'Create NonAvailabilityOfStaff', 'url'=>array('create')),
	array('label'=>'Update NonAvailabilityOfStaff', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NonAvailabilityOfStaff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>View NonAvailabilityOfStaff #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'staff_id',
		'date',
		'start_time',
		'end_time',
		'already_booked',
		'is_disabled',
	),
)); ?>
