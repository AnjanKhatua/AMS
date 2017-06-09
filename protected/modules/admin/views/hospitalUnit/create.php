<?php
/* @var $this HospitalUnitController */
/* @var $model HospitalUnit */

$this->breadcrumbs=array(
	'Hospitals'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List HospitalUnit', 'url'=>array('index')),
	array('label'=>'Manage HospitalUnit', 'url'=>array('admin')),
);
?>

<h1>Create Hospital</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>