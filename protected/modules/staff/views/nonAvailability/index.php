<?php
/* @var $this NonAvailabilityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Non Availabilities',
);

$this->menu=array(
	array('label'=>'Create Non Availability', 'url'=>array('create')),
	array('label'=>'Manage Non Availability', 'url'=>array('admin')),
);
?>

<h1>Non Availabilities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
