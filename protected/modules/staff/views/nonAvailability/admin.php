<?php
/* @var $this NonAvailabilityController */
/* @var $model NonAvailability */

$this->breadcrumbs=array(
	'Non Availabilities'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Non Availability', 'url'=>array('index')),
	array('label'=>'Create Non Availability', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#non-availability-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Non Availabilities</h1>

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
	'id'=>'non-availability-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'non_availablility_id',
                                        array("name"=>"start_date","value"=>'Utility::changeDateToUK($data->start_date)'),
                                        array("name"=>"end_date","value"=>'Utility::changeDateToUK($data->end_date)'),
		'start_time',
		'end_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
