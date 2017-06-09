<?php
/* @var $this UserActivityController */
/* @var $model UserActivity */

$this->breadcrumbs=array(
	'User Activities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserActivity', 'url'=>array('index')),
	array('label'=>'Manage UserActivity', 'url'=>array('admin')),
);
?>

<h1>Create UserActivity</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>