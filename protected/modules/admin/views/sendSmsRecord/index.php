<?php
/* @var $this SendSmsRecordController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Send Sms Records',
);

$this->menu=array(
	array('label'=>'Create SendSmsRecord', 'url'=>array('create')),
	array('label'=>'Manage SendSmsRecord', 'url'=>array('admin')),
);
?>

<h1>Send Sms Records</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
