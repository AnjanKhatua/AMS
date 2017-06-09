<?php
/* @var $this UploadedTimesheetByStaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Uploaded Timesheet By Staff',
);

$this->menu=array(
	array('label'=>'Create Upload Timesheet By Staff', 'url'=>array('create')),
	array('label'=>'Manage Upload Timesheet By Staff', 'url'=>array('admin')),
);
?>

<h1>Uploaded Time-sheet By Staff</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
