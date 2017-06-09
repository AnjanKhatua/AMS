<?php
/* @var $this TimesheetPaymentDetailsForHospitalController */
/* @var $model TimesheetPaymentDetailsForHospital */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Hospitals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment For Hospital', 'url'=>array('index')),
	array('label'=>'Create Timesheet Payment For Hospital', 'url'=>array('create')),
	array('label'=>'View Timesheet Payment For Hospital', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Timesheet Payment For Hospital', 'url'=>array('admin')),
);
?>

<h1>Update Time-sheet Payment Details For Hospital <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>