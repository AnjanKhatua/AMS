<?php
/* @var $this WorkAreaController */
/* @var $model WorkArea */

$this->breadcrumbs=array(
	'Work Areas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WorkArea', 'url'=>array('index')),
	array('label'=>'Manage WorkArea', 'url'=>array('admin')),
);
?>

<h1>Create Work Area</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>