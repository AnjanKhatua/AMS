<?php
/* @var $this TimesheetTrainingDeductionWeekController */
/* @var $model TimesheetTrainingDeductionWeek */

$this->breadcrumbs=array(
	'Timesheet Training Deduction Weeks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TimesheetTrainingDeductionWeek', 'url'=>array('index')),
	array('label'=>'Create TimesheetTrainingDeductionWeek', 'url'=>array('create')),
	array('label'=>'View TimesheetTrainingDeductionWeek', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TimesheetTrainingDeductionWeek', 'url'=>array('admin')),
);
?>

<h1>Update TimesheetTrainingDeductionWeek <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>