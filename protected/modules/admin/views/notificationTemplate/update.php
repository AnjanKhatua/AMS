<?php
/* @var $this NotificationTemplateController */
/* @var $model NotificationTemplate */

$this->breadcrumbs=array(
	'Notification Templates'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List NotificationTemplate', 'url'=>array('index')),
//	array('label'=>'Create Notification Template', 'url'=>array('create')),
	array('label'=>'View Notification Template', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Notification Template', 'url'=>array('admin')),
);
?>

<h1>Update Notification Template <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>