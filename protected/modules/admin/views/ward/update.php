<?php
/* @var $this WardController */
/* @var $model Ward */

$this->breadcrumbs=array(
	'Wards'=>array('index'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Ward', 'url'=>array('index')),
	array('label'=>'Create Ward', 'url'=>array('create')),
	array('label'=>'View Ward', 'url'=>array('view', 'id'=>$model->ward_id)),
	array('label'=>'Manage Ward', 'url'=>array('admin')),
);
?>

<h1>Update Ward</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>