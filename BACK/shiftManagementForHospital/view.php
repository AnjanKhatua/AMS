<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */

$this->breadcrumbs=array(
	'Shift Management For Hospitals',
	$model->staff_request_id,
);

$this->menu=array(
	//array('label'=>'List ShiftManagementForHospital', 'url'=>array('index')),
	array('label'=>'Create Shift For Hospital', 'url'=>array('create')),
	array('label'=>'Update Shift For Hospital', 'url'=>array('update', 'id'=>$model->staff_request_id)),
	array('label'=>'Delete Shift For Hospital', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->staff_request_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shift For Hospital', 'url'=>array('admin')),
);
?>

<h1>View ShiftManagementForHospital #<?php echo $model->staff_request_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'staff_request_id',
		
		array(
			'name'=>'hospital_unit_id',
			'value'=>$model->hospitalUnit->hospital_unit,
		),
		array(
			'name'=>'job_type_id',
			'value'=>$model->jobType->job_type,
		),
		'quantity',
		'date',
		'shift_start_time',
		'shift_end_time',
		'requested_date',
		'requested_time',
		'requested_person',
		array(
			'name'=>'request_accepted_by',
			'value'=>$model->requestAcceptedBy->first_name,
		),
		'requested_person_mobile_number',
	),
)); ?>
