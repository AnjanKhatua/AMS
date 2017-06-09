<?php
/* @var $this PayTypeController */
/* @var $model PayType */

$this->breadcrumbs=array(
	'Pay Types'=>array('index'),
	$model->pay_type_id=>array('view','id'=>$model->pay_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PayType', 'url'=>array('index')),
	array('label'=>'Create PayType', 'url'=>array('create')),
	array('label'=>'View PayType', 'url'=>array('view', 'id'=>$model->pay_type_id)),
	array('label'=>'Manage PayType', 'url'=>array('admin')),
);
?>

<h1>Update Pay Type <?php echo $model->pay_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>