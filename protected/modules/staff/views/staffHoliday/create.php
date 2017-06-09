<?php
/* @var $this StaffHolidayController */
/* @var $model StaffHoliday */

$this->breadcrumbs=array(
	'Staff Holidays'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Staff Holiday', 'url'=>array('index')),
	array('label'=>'Manage Staff Holiday', 'url'=>array('admin')),
);
?>

<h1>Create Staff Holiday</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'chkData' => $chkData, 'chkData1' => $chkData1)); ?>