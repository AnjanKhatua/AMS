<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shift Management For Hospitals',
);

$this->menu=array(
	array('label'=>'Create ShiftManagementForHospital', 'url'=>array('create')),
	array('label'=>'Manage ShiftManagementForHospital', 'url'=>array('admin')),
);
?>

<h1>Shift Management For Hospitals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
