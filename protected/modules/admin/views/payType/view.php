<?php
/* @var $this PayTypeController */
/* @var $model PayType */

$this->breadcrumbs=array(
	'Pay Types'=>array('index'),
	$model->pay_type_id,
);

$this->menu=array(
	array('label'=>'List PayType', 'url'=>array('index')),
	array('label'=>'Create PayType', 'url'=>array('create')),
	array('label'=>'Update PayType', 'url'=>array('update', 'id'=>$model->pay_type_id)),
	array('label'=>'Delete PayType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pay_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PayType', 'url'=>array('admin')),
);
?>

<h1>View Pay Type #<?php echo $model->pay_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pay_type_id',
		'pay_type',
		'pay_type_active_status',
	),
)); ?>
