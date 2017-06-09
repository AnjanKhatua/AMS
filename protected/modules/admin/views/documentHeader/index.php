<?php
/* @var $this DocumentHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Document Headers',
);

$this->menu=array(
	array('label'=>'Create Document Header', 'url'=>array('create')),
	array('label'=>'Manage Document Header', 'url'=>array('admin')),
);
?>

<h1>Document Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
