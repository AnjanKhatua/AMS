<?php
/* @var $this StaffRegistrationController */
/* @var $model StaffRegistration */

$this->breadcrumbs=array(
	'Staff Registrations'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List StaffRegistration', 'url'=>array('index')),
	array('label'=>'Manage Staff Registration', 'url'=>array('admin')),
);
?>

<h1>Create Staff Registration</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>