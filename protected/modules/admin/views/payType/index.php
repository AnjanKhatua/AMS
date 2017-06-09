<?php
/* @var $this PayTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pay Types',
);

$this->menu=array(
	array('label'=>'Create PayType', 'url'=>array('create')),
	array('label'=>'Manage PayType', 'url'=>array('admin')),
);
?>

<h1>Pay Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
