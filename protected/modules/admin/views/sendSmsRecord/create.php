<?php
/* @var $this SendSmsRecordController */
/* @var $model SendSmsRecord */

$this->breadcrumbs=array(
	'Send Sms Records'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SendSmsRecord', 'url'=>array('index')),
	array('label'=>'Manage SendSmsRecord', 'url'=>array('admin')),
);
?>

<h1>Create SendSmsRecord</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>