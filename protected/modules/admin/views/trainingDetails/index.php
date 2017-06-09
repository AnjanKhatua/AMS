<?php
/* @var $this TrainingDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Training Details',
);

$this->menu=array(
	array('label'=>'Create Training Details', 'url'=>array('create')),
	array('label'=>'Manage Training Details', 'url'=>array('admin')),
);
?>

<h1>Training Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
