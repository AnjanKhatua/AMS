<?php
/* @var $this UploadedTimesheetByStaffController */
/* @var $model UploadedTimesheetByStaff */

$this->breadcrumbs=array(
	'Uploaded Timesheet By Staff'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Upload Timesheet By Staff', 'url'=>array('index')),
	array('label'=>'Create Upload Timesheet By Staff', 'url'=>array('create')),
	array('label'=>'Update Upload Timesheet By Staff', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Upload Timesheet By Staff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Upload Timesheet By Staff', 'url'=>array('admin')),
);
?>

<h1>View Upload Time-sheet By Staff #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'staff_id',
		'ip',
		'week_end_date',
		'upload_date_time',
		'timesheet_name',
	),
)); ?>
