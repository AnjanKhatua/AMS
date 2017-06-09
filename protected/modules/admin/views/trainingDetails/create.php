<?php
/* @var $this TrainingDetailsController */
/* @var $model TrainingDetails */

$this->breadcrumbs=array(
	'Training Details'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Training Details', 'url'=>array('index')),
	array('label'=>'Manage Training Details', 'url'=>array('admin')),
);
?>

<h1>Create Training Details</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>