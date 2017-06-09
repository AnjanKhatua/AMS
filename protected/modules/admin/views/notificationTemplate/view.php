<?php
/* @var $this NotificationTemplateController */
/* @var $model NotificationTemplate */

$this->breadcrumbs=array(
	'Notification Templates'=>array('index'),
	$model->name,
);

$this->menu=array(
//	array('label'=>'List NotificationTemplate', 'url'=>array('index')),
//	array('label'=>'Create Notification Template', 'url'=>array('create')),
	array('label'=>'Update Notification Template', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Notification Template', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notification Template', 'url'=>array('admin')),
);
?>

<h1>View Notification Template #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'subject',
		'body',
		'sms_body',
		'sender_email',
	),
)); ?>
