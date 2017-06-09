<?php
/* @var $this NonAvailabilityOfStaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Non Availability Of Staff',
);

$this->menu=array(
	array('label'=>'Create NonAvailabilityOfStaff', 'url'=>array('create')),
	array('label'=>'Manage NonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>Non Availability Of Staff</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
