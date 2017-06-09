<?php
/* @var $this WardController */
/* @var $model Ward */

$this->breadcrumbs=array(
	'Wards'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Ward', 'url'=>array('index')),
	array('label'=>'Manage Ward', 'url'=>array('admin')),
);
?>

<h1>Create Ward</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>