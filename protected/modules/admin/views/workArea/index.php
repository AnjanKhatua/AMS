<?php
/* @var $this WorkAreaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Work Areas',
);

$this->menu=array(
	array('label'=>'Create WorkArea', 'url'=>array('create')),
	array('label'=>'Manage WorkArea', 'url'=>array('admin')),
);
?>

<h1>Work Areas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
