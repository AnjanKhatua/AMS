<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Staff',
);

$this->menu=array(
	array('label'=>'Create Timesheet Payment Details For Staff', 'url'=>array('create')),
	array('label'=>'Manage Timesheet Payment Details For Staff', 'url'=>array('admin')),
);
?>

<h1>Time-sheet Payment Details For Staff</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
