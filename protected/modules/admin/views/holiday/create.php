<?php
/* @var $this HolidayController */
/* @var $model Holiday */

$this->breadcrumbs=array(
	'Holidays'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Holiday', 'url'=>array('index')),
	array('label'=>'Manage Holiday', 'url'=>array('admin')),
);
?>

<h1>Create Holiday</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>