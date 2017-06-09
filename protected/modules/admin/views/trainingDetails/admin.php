<?php
/* @var $this TrainingDetailsController */
/* @var $model TrainingDetails */

$this->breadcrumbs=array(
	'Training Details'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Training Details', 'url'=>array('index')),
	array('label'=>'Create Training Details', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#training-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Training Details</h1>

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
	'id'=>'training-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
//		'training_id',
                                    array(
                                        'name' => 'course_name',
                                        'value' => '$data->allTrainings->course_name',
                                    ),
                                    array(
                                        'name' => 'email',
                                        'value' => '$data->staff->email',
                                    ),
//		'staff_id',
		'fees_paid_date',
		'fees',
		'deduction_amount',
		'remaining_amount',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
