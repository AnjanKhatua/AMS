<?php
/* @var $this ShiftEnquiryAckController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shift Enquiry Acks',
);

$this->menu=array(
	array('label'=>'Create ShiftEnquiryAck', 'url'=>array('create')),
	array('label'=>'Manage ShiftEnquiryAck', 'url'=>array('admin')),
);
?>

<h1>Shift Enquiry Acks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
