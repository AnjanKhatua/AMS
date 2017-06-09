<?php
/* @var $this UploadedTimesheetByStaffController */
/* @var $model UploadedTimesheetByStaff */

$this->breadcrumbs=array(
	'Uploaded Timesheet By Staff'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Upload Timesheet By Staff', 'url'=>array('index')),
	array('label'=>'Create Upload Timesheet By Staff', 'url'=>array('create')),
	array('label'=>'View Upload Timesheet By Staff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Upload Timesheet By Staff', 'url'=>array('admin')),
);
?>

<h1>Update Upload Time-sheet By Staff <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>