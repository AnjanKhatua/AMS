<?php
/* @var $this NotificationLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Notification Logs',
);

$this->menu=array(
	array('label'=>'Create NotificationLog', 'url'=>array('create')),
	array('label'=>'Manage NotificationLog', 'url'=>array('admin')),
);
?>

<h1>Notification Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
