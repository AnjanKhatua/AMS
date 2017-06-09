<?php
/* @var $this TimesheetPaymentDetailsForHospitalController */
/* @var $model TimesheetPaymentDetailsForHospital */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Hospitals'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment For Hospital', 'url'=>array('index')),
	array('label'=>'Manage Timesheet Payment For Hospital', 'url'=>array('admin')),
);
?>

<h1>Create Time-sheet Payment Details For Hospital</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>