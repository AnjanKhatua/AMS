<?php
/* @var $this ServiceCompletedController */
/* @var $model ServiceCompleted */

$this->breadcrumbs=array(
	'Service Completeds'=>array('index'),
	$model->service_id,
);

$this->menu=array(
	array('label'=>'List ServiceCompleted', 'url'=>array('index')),
	array('label'=>'Create ServiceCompleted', 'url'=>array('create')),
	array('label'=>'Update ServiceCompleted', 'url'=>array('update', 'id'=>$model->service_id)),
	array('label'=>'Delete ServiceCompleted', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->service_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServiceCompleted', 'url'=>array('admin')),
);
?>

<h1>View ServiceCompleted #<?php echo $model->service_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'service_id',
		'staff_id',
		'enquiry_id',
		'hospital_unit_id',
		'booking_id',
		'date',
		'shift_start_time',
		'shift_end_time',
		'staff_category',
	),
)); ?>
