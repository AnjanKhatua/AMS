<?php
/* @var $this ServiceCompletedController */
/* @var $model ServiceCompleted */

$this->breadcrumbs=array(
	'Service Completeds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServiceCompleted', 'url'=>array('index')),
	array('label'=>'Manage ServiceCompleted', 'url'=>array('admin')),
);
?>

<h1>Create ServiceCompleted</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>