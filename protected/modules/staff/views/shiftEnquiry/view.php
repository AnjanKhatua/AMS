<?php
/* @var $this ShiftEnquiryController */
/* @var $model ShiftEnquiry */

$this->breadcrumbs=array(
	'Shift Enquiries'=>array('index'),
	$model->enquiry_id,
);

$this->menu=array(
//	array('label'=>'List Shift Enquiry', 'url'=>array('index')),
//	array('label'=>'Create Shift Enquiry', 'url'=>array('create')),
	array('label'=>'Update Shift Enquiry', 'url'=>array('update', 'id'=>$model->enquiry_id)),
//	array('label'=>'Delete Shift Enquiry', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->enquiry_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shift Enquiry', 'url'=>array('admin')),
);
?>

<h1>View Shift Enquiry </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'enquiry_id',
//		'staff_request_id',
//		'staff_id',
//		'enquired_by',
		'availability_confirmed_by_staff',
		'availability_confirmed_via',
		'confirmed_by',
//		'agent_user_id',
		'is_confirmed',
	),
)); ?>
