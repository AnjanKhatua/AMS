<?php
/* @var $this PaymentDetailsOfTrainingController */
/* @var $model PaymentDetailsOfTraining */

$this->breadcrumbs=array(
	'Payment Details Of Trainings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PaymentDetailsOfTraining', 'url'=>array('index')),
	array('label'=>'Manage PaymentDetailsOfTraining', 'url'=>array('admin')),
);
?>

<h1>Create PaymentDetailsOfTraining</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>