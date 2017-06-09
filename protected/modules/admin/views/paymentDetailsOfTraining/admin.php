<?php
/* @var $this PaymentDetailsOfTrainingController */
/* @var $model PaymentDetailsOfTraining */

$this->breadcrumbs=array(
	'Payment Details Of Trainings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PaymentDetailsOfTraining', 'url'=>array('index')),
	array('label'=>'Create PaymentDetailsOfTraining', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#payment-details-of-training-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Payment Details Of Trainings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'payment-details-of-training-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'training_details_id',
		'date',
		'amount',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
