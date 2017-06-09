<?php
/* @var $this StaffJobTypeMapController */
/* @var $model StaffJobTypeMap */

$this->breadcrumbs=array(
	'Staff Job Type Maps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StaffJobTypeMap', 'url'=>array('index')),
	array('label'=>'Manage StaffJobTypeMap', 'url'=>array('admin')),
);
?>

<h1>Create StaffJobTypeMap</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>