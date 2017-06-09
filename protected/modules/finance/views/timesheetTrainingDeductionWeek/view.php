<?php
/* @var $this TimesheetTrainingDeductionWeekController */
/* @var $model TimesheetTrainingDeductionWeek */

$this->breadcrumbs=array(
	'Timesheet Training Deduction Weeks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TimesheetTrainingDeductionWeek', 'url'=>array('index')),
	array('label'=>'Create TimesheetTrainingDeductionWeek', 'url'=>array('create')),
	array('label'=>'Update TimesheetTrainingDeductionWeek', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TimesheetTrainingDeductionWeek', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TimesheetTrainingDeductionWeek', 'url'=>array('admin')),
);
?>

<h1>View TimesheetTrainingDeductionWeek #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'staff_id',
		'invoice_date',
		'week_end_date',
		'apply_status',
	),
)); ?>
