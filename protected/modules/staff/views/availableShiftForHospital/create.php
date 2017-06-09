<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $model AvailableShiftForHospital */

$this->breadcrumbs=array(
	'Available Shift For Hospitals'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Available Shift For Hospital', 'url'=>array('index')),
	array('label'=>'Manage Available Shift For Hospital', 'url'=>array('admin')),
);
?>

<h1>Create Available Shift For Hospital</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>