<?php
/* @var $this TimesheetTrainingDeductionWeekController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Timesheet Training Deduction Weeks',
);

$this->menu=array(
	array('label'=>'Create TimesheetTrainingDeductionWeek', 'url'=>array('create')),
	array('label'=>'Manage TimesheetTrainingDeductionWeek', 'url'=>array('admin')),
);
?>

<h1>Timesheet Training Deduction Weeks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
