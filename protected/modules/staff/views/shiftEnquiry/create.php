<?php
/* @var $this ShiftEnquiryController */
/* @var $model ShiftEnquiry */

$this->breadcrumbs=array(
	'Shift Enquiries'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Shift Enquiry', 'url'=>array('index')),
	array('label'=>'Manage Shift Enquiry', 'url'=>array('admin')),
);
?>

<h1>Create Shift Enquiry</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>