<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Staff'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment Details For Staff', 'url'=>array('index')),
	array('label'=>'Create Timesheet Payment Details For Staff', 'url'=>array('create')),
	array('label'=>'View Timesheet Payment Details For Staff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Timesheet Payment Details For Staff', 'url'=>array('admin')),
);
?>

<h1>Update Time-sheet Payment Details For Staff <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>