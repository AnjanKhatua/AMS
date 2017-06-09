<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Available Shift For Hospitals',
);

$this->menu=array(
	array('label'=>'Create Available Shift For Hospital', 'url'=>array('create')),
	array('label'=>'Manage Available Shift For Hospital', 'url'=>array('admin')),
);
?>

<h1>Available Shift For Hospitals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
