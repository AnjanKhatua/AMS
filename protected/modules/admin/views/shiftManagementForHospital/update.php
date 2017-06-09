<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */

$this->breadcrumbs=array(
	'Shift For Hospitals'=>array('index'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List ShiftManagementForHospital', 'url'=>array('index')),
	array('label'=>'Create Shift For Hospital', 'url'=>array('create')),
	array('label'=>'View Shift For Hospital', 'url'=>array('view', 'id'=>$model->staff_request_id)),
	array('label'=>'Manage Shift For Hospital', 'url'=>array('admin')),
);
?>

<h1>Update Shift For Hospital</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>