<?php
/* @var $this TimesheetPaymentDetailsForHospitalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Hospitals',
);

$this->menu=array(
	array('label'=>'Create Timesheet Payment For Hospital', 'url'=>array('create')),
	array('label'=>'Manage Timesheet Payment For Hospital', 'url'=>array('admin')),
);
?>

<h1>Time-sheet Payment Details For Hospitals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
