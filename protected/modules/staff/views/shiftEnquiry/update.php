<?php
/* @var $this ShiftEnquiryController */
/* @var $model ShiftEnquiry */

$this->breadcrumbs=array(
	'Shift Enquiries'=>array('index'),
	$model->enquiry_id=>array('view','id'=>$model->enquiry_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Shift Enquiry', 'url'=>array('index')),
//	array('label'=>'Create Shift Enquiry', 'url'=>array('create')),
	array('label'=>'View Shift Enquiry', 'url'=>array('view', 'id'=>$model->enquiry_id)),
	array('label'=>'Manage Shift Enquiry', 'url'=>array('admin')),
);
?>

<h1>Update Shift Enquiry </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>