<?php
/* @var $this RegularNonAvailabilityOfStaffController */
/* @var $model RegularNonAvailabilityOfStaff */

$this->breadcrumbs=array(
	'Regular Non Availability Of Staff'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RegularNonAvailabilityOfStaff', 'url'=>array('index')),
	array('label'=>'Create RegularNonAvailabilityOfStaff', 'url'=>array('create')),
	array('label'=>'Update RegularNonAvailabilityOfStaff', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RegularNonAvailabilityOfStaff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegularNonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>View RegularNonAvailabilityOfStaff #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'non_availablility_id',
		'date',
		'start_time',
		'end_time',
		'already_booked',
	),
)); ?>
