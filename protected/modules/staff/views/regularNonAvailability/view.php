<?php
/* @var $this RegularNonAvailabilityController */
/* @var $model RegularNonAvailability */

$this->breadcrumbs=array(
	'Regular Non Availabilities'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Regular Non Availability', 'url'=>array('index')),
	array('label'=>'Create Regular Non Availability', 'url'=>array('create')),
	array('label'=>'Update Regular Non Availability', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Regular Non Availability', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Regular Non Availability', 'url'=>array('admin')),
);
?>

<h1>View RegularNonAvailability #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'non_availablility_id',
		'date',
		'start_time',
		'end_time',
	),
)); ?>
