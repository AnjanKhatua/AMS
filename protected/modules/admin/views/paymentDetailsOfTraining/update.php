<?php
/* @var $this PaymentDetailsOfTrainingController */
/* @var $model PaymentDetailsOfTraining */

$this->breadcrumbs=array(
	'Payment Details Of Trainings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PaymentDetailsOfTraining', 'url'=>array('index')),
	array('label'=>'Create PaymentDetailsOfTraining', 'url'=>array('create')),
	array('label'=>'View PaymentDetailsOfTraining', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PaymentDetailsOfTraining', 'url'=>array('admin')),
);
?>

<h1>Update PaymentDetailsOfTraining <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>