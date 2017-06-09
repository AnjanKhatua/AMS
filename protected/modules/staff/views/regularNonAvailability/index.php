<?php
/* @var $this RegularNonAvailabilityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Regular Non Availabilities',
);

$this->menu=array(
	array('label'=>'Create Regular Non Availability', 'url'=>array('create')),
	array('label'=>'Manage Regular Non Availability', 'url'=>array('admin')),
);
?>

<h1>Regular Non Availabilities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
