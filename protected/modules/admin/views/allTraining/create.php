<?php
/* @var $this AllTrainingController */
/* @var $model AllTraining */

$this->breadcrumbs=array(
	'All Trainings'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List All Training', 'url'=>array('index')),
	array('label'=>'Manage Training', 'url'=>array('admin')),
);
?>

<h1>Create Training</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>