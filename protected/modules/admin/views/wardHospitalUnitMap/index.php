<?php
/* @var $this WardHospitalUnitMapController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ward Hospital Unit Maps',
);

$this->menu=array(
	array('label'=>'Create WardHospitalUnitMap', 'url'=>array('create')),
	array('label'=>'Manage WardHospitalUnitMap', 'url'=>array('admin')),
);
?>

<h1>Ward Hospital Unit Maps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
