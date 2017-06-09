<?php
/* @var $this RegularNonAvailabilityOfStaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Regular Non Availability Of Staff',
);

$this->menu=array(
	array('label'=>'Create RegularNonAvailabilityOfStaff', 'url'=>array('create')),
	array('label'=>'Manage RegularNonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>Regular Non Availability Of Staff</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
