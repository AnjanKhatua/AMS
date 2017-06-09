<?php
/* @var $this PayTypeController */
/* @var $model PayType */

$this->breadcrumbs=array(
	'Pay Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PayType', 'url'=>array('index')),
	array('label'=>'Manage PayType', 'url'=>array('admin')),
);
?>

<h1>Create Pay Type</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>