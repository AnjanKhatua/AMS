<?php
/* @var $this UserActivityController */
/* @var $model UserActivity */

$this->breadcrumbs=array(
	'User Activities'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserActivity', 'url'=>array('index')),
	array('label'=>'Create UserActivity', 'url'=>array('create')),
	array('label'=>'Update UserActivity', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserActivity', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserActivity', 'url'=>array('admin')),
);
?>

<h1>View UserActivity #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'ip',
		'time',
		'details',
		'module_name',
		'activity',
		'is_successful',
	),
)); ?>
