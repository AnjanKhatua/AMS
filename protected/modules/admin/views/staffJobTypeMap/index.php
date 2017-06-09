<?php
/* @var $this StaffJobTypeMapController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Job Type Maps',
);

$this->menu=array(
	array('label'=>'Create StaffJobTypeMap', 'url'=>array('create')),
	array('label'=>'Manage StaffJobTypeMap', 'url'=>array('admin')),
);
?>

<h1>Staff Job Type Maps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
