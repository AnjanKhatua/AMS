<?php
/* @var $this NotificationLogController */
/* @var $model NotificationLog */

$this->breadcrumbs=array(
	'Notification Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NotificationLog', 'url'=>array('index')),
	array('label'=>'Create NotificationLog', 'url'=>array('create')),
	array('label'=>'Update NotificationLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NotificationLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NotificationLog', 'url'=>array('admin')),
);
?>

<h1>View NotificationLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'notification_type',
		'send_to',
		'send_from',
		'notification_sub',
		'notification_body',
		'send_datetime',
		'ip',
	),
)); ?>
