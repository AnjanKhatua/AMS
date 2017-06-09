<?php
/* @var $this PaymentDetailsOfTrainingController */
/* @var $model PaymentDetailsOfTraining */

$this->breadcrumbs=array(
	'Payment Details Of Trainings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PaymentDetailsOfTraining', 'url'=>array('index')),
	array('label'=>'Create PaymentDetailsOfTraining', 'url'=>array('create')),
	array('label'=>'Update PaymentDetailsOfTraining', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PaymentDetailsOfTraining', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaymentDetailsOfTraining', 'url'=>array('admin')),
);
?>

<h1>View PaymentDetailsOfTraining #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'training_details_id',
		'date',
		'amount',
	),
)); ?>
