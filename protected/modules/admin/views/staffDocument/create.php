<?php
/* @var $this StaffDocumentController */
/* @var $model StaffDocument */

$this->breadcrumbs=array(
	'Staff Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StaffDocument', 'url'=>array('index')),
	array('label'=>'Manage StaffDocument', 'url'=>array('admin')),
);
?>

<h1>Create StaffDocument</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>