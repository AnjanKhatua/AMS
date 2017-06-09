<?php
/* @var $this HospitalJobTypeRateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Hospital Job Type Rates',
);

$this->menu=array(
	array('label'=>'Create Hospital Job Type Rate', 'url'=>array('create')),
	array('label'=>'Manage Hospital Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>Hospital Job Type Rates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
