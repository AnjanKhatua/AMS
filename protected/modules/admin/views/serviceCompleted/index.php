<?php
/* @var $this ServiceCompletedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Completeds',
);

$this->menu=array(
	array('label'=>'Create ServiceCompleted', 'url'=>array('create')),
	array('label'=>'Manage ServiceCompleted', 'url'=>array('admin')),
);
?>

<h1>Service Completeds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
