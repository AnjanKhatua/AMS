<?php
/* @var $this ServiceCompletedController */
/* @var $model ServiceCompleted */

$this->breadcrumbs=array(
	'Service Completeds'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ServiceCompleted', 'url'=>array('index')),
	array('label'=>'Create ServiceCompleted', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#service-completed-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Service Completeds</h1>

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
	'id'=>'service-completed-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'service_id',
		'staff_id',
		'enquiry_id',
		'hospital_unit_id',
		'booking_id',
		'date',
		/*
		'shift_start_time',
		'shift_end_time',
		'staff_category',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
