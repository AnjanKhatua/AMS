<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Staff'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment Details For Staff', 'url'=>array('index')),
	array('label'=>'Manage Timesheet Payment Details For Staff', 'url'=>array('admin')),
);
?>

<h1>Create Time-sheet Payment Details For Staff</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>