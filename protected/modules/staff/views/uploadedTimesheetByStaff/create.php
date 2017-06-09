<?php
/* @var $this UploadedTimesheetByStaffController */
/* @var $model UploadedTimesheetByStaff */

$this->breadcrumbs=array(
	'Uploaded Timesheet By Staff'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Upload Timesheet By Staff', 'url'=>array('index')),
	array('label'=>'Manage Upload Timesheet By Staff', 'url'=>array('admin')),
);
?>

<h1>Create Upload Time-sheet By Staff</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>