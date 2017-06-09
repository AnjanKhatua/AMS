<?php
/* @var $this StaffHolidayController */
/* @var $model StaffHoliday */

$this->breadcrumbs=array(
	'Staff Holidays'=>array('index'),
	$model->holiday_id,
);

$this->menu=array(
//	array('label'=>'List Staff Holiday', 'url'=>array('index')),
	array('label'=>'Create Staff Holiday', 'url'=>array('create')),
	array('label'=>'Update Staff Holiday', 'url'=>array('update', 'id'=>$model->holiday_id)),
	array('label'=>'Delete Staff Holiday', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->holiday_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Staff Holiday', 'url'=>array('admin')),
);
?>

<h1>View Staff Holiday #<?php echo $model->holiday_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'holiday_id',
		'staff_id',
		array("name"=>"start_date","value"=>Utility::changeDateToUK($model->start_date)),
                                        array("name"=>"end_date","value"=>Utility::changeDateToUK($model->end_date)),
	),
)); ?>
