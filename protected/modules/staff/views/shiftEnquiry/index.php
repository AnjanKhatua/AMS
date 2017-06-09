<?php
/* @var $this ShiftEnquiryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shift Enquiries',
);

$this->menu=array(
	array('label'=>'Create Shift Enquiry', 'url'=>array('create')),
	array('label'=>'Manage Shift Enquiry', 'url'=>array('admin')),
);
?>

<h1>Shift Enquiries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
