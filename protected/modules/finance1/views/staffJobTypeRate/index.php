<?php
/* @var $this StaffJobTypeRateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Job Type Rates',
);

$this->menu=array(
	array('label'=>'Create Staff Job Type Rate', 'url'=>array('create')),
	array('label'=>'Manage Staff Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>Staff Job Type Rates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
