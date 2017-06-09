<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */

$this->breadcrumbs=array(
	'Hospital Group'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List HospitalRegistration', 'url'=>array('index')),
	array('label'=>'Manage Hospital Group', 'url'=>array('admin')),
);
?>

<h1>Create Hospital Group</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>