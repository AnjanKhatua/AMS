<?php
/* @var $this TimesheetTrainingDeductionWeekController */
/* @var $model TimesheetTrainingDeductionWeek */

$this->breadcrumbs=array(
	'Timesheet Training Deduction Weeks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TimesheetTrainingDeductionWeek', 'url'=>array('index')),
	array('label'=>'Manage TimesheetTrainingDeductionWeek', 'url'=>array('admin')),
);
?>

<h1>Create TimesheetTrainingDeductionWeek</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>