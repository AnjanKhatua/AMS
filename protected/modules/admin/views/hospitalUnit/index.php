<?php
/* @var $this HospitalUnitController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Hospital Units',
);

$this->menu=array(
	array('label'=>'Create HospitalUnit', 'url'=>array('create')),
	array('label'=>'Manage HospitalUnit', 'url'=>array('admin')),
);
?>

<h1>Hospital Units</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
