<?php
/* @var $this DocumentHeaderController */
/* @var $model DocumentHeader */

$this->breadcrumbs=array(
	'Document Headers'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Document Header', 'url'=>array('index')),
	array('label'=>'Manage Document Header', 'url'=>array('admin')),
);
?>

<h1>Create Document Header</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>