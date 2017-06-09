<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */

$this->breadcrumbs=array(
	'Hospital Group'=>array('index'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List HospitalRegistration', 'url'=>array('index')),
	array('label'=>'Create Hospital Group', 'url'=>array('create')),
	//array('label'=>'View HospitalRegistration', 'url'=>array('view', 'id'=>$model->hospital_id)),
	array('label'=>'Manage Hospital Group', 'url'=>array('admin')),
);
?>

<h1>Update Hospital Group</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>