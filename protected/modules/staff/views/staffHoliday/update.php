<?php
/* @var $this StaffHolidayController */
/* @var $model StaffHoliday */

$this->breadcrumbs=array(
	'Staff Holidays'=>array('index'),
	$model->holiday_id=>array('view','id'=>$model->holiday_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Staff Holiday', 'url'=>array('index')),
	array('label'=>'Create Staff Holiday', 'url'=>array('create')),
	array('label'=>'View Staff Holiday', 'url'=>array('view', 'id'=>$model->holiday_id)),
	array('label'=>'Manage Staff Holiday', 'url'=>array('admin')),
);
?>

<h1>Update Staff Holiday <?php echo $model->holiday_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'chkData' => $chkData, 'chkData1' => $chkData1)); ?>