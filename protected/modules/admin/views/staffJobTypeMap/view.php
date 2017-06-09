<?php
/* @var $this StaffJobTypeMapController */
/* @var $model StaffJobTypeMap */

$this->breadcrumbs=array(
	'Staff Job Type Maps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StaffJobTypeMap', 'url'=>array('index')),
	array('label'=>'Create StaffJobTypeMap', 'url'=>array('create')),
	array('label'=>'Update StaffJobTypeMap', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StaffJobTypeMap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StaffJobTypeMap', 'url'=>array('admin')),
);
?>

<h1>View StaffJobTypeMap #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'staff_id',
		'job_type_id',
	),
)); ?>
