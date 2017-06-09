<?php
/* @var $this PaymentDetailsOfTrainingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Payment Details Of Trainings',
);

$this->menu=array(
	array('label'=>'Create PaymentDetailsOfTraining', 'url'=>array('create')),
	array('label'=>'Manage PaymentDetailsOfTraining', 'url'=>array('admin')),
);
?>

<h1>Payment Details Of Trainings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
