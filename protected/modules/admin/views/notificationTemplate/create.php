<?php
/* @var $this NotificationTemplateController */
/* @var $model NotificationTemplate */

$this->breadcrumbs=array(
	'Notification Templates'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List NotificationTemplate', 'url'=>array('index')),
	array('label'=>'Manage Notification Template', 'url'=>array('admin')),
);
?>

<h1>Create Notification Template</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>