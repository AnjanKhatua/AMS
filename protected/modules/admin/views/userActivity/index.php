<?php
/* @var $this UserActivityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Activities',
);

$this->menu=array(
	array('label'=>'Create UserActivity', 'url'=>array('create')),
	array('label'=>'Manage UserActivity', 'url'=>array('admin')),
);
?>

<h1>User Activities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
