<?php
/* @var $this JobTypeController */
/* @var $model JobType */

$this->breadcrumbs=array(
	'Job Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List JobType', 'url'=>array('index')),
	array('label'=>'Manage JobType', 'url'=>array('admin')),
);
?>

<h1>Create Job Type</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>