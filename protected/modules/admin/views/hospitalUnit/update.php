<?php
/* @var $this HospitalUnitController */
/* @var $model HospitalUnit */

$this->breadcrumbs=array(
	'Hospitals'=>array('index'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List HospitalUnit', 'url'=>array('index')),
	array('label'=>'Create Hospital', 'url'=>array('create')),
	array('label'=>'View Hospital', 'url'=>array('view', 'id'=>$model->hospital_unit_id)),
	array('label'=>'Manage Hospital', 'url'=>array('admin')),
);
?>

<h1>Update Hospital</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>