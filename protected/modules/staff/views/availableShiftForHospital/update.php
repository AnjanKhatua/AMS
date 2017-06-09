<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $model AvailableShiftForHospital */

$this->breadcrumbs=array(
	'Available Shift For Hospitals'=>array('index'),
	$model->staff_request_id=>array('view','id'=>$model->staff_request_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Available Shift For Hospital', 'url'=>array('index')),
//	array('label'=>'Create Available Shift For Hospital', 'url'=>array('create')),
	array('label'=>'View Available Shift For Hospital', 'url'=>array('view', 'id'=>$model->staff_request_id)),
	array('label'=>'Manage Available Shift For Hospital', 'url'=>array('admin')),
);
?>

<h1>Update Available Shift For Hospital</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>