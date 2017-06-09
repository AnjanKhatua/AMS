<?php
/* @var $this NotificationLogController */
/* @var $model NotificationLog */

$this->breadcrumbs=array(
	'Notification Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NotificationLog', 'url'=>array('index')),
	array('label'=>'Create NotificationLog', 'url'=>array('create')),
	array('label'=>'View NotificationLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NotificationLog', 'url'=>array('admin')),
);
?>

<h1>Update NotificationLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>