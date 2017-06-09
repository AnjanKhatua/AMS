<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */

$this->breadcrumbs=array(
	'Timesheets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Timesheet', 'url'=>array('index')),
	array('label'=>'Create Timesheet', 'url'=>array('create')),
	array('label'=>'View Timesheet', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Timesheet', 'url'=>array('admin')),
);
?>

<h1>Update Time-sheet <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>