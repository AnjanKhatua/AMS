<?php
/* @var $this SendSmsRecordController */
/* @var $model SendSmsRecord */

$this->breadcrumbs=array(
	'Send Sms Records'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SendSmsRecord', 'url'=>array('index')),
	array('label'=>'Create SendSmsRecord', 'url'=>array('create')),
	array('label'=>'View SendSmsRecord', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SendSmsRecord', 'url'=>array('admin')),
);
?>

<h1>Update SendSmsRecord <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>