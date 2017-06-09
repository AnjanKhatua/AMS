<?php
/* @var $this AllTrainingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'All Trainings',
);

$this->menu=array(
	array('label'=>'Create Training', 'url'=>array('create')),
	array('label'=>'Manage Training', 'url'=>array('admin')),
);
?>

<h1>All Training</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
