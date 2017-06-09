<?php
/* @var $this NotificationLogController */
/* @var $model NotificationLog */

$this->breadcrumbs=array(
	'Notification Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NotificationLog', 'url'=>array('index')),
	array('label'=>'Manage NotificationLog', 'url'=>array('admin')),
);
?>

<h1>Create NotificationLog</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>