<?php
/* @var $this StaffJobTypeRateController */
/* @var $model StaffJobTypeRate */

$this->breadcrumbs=array(
	'Staff Job Type Rates'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Staff Job Type Rate', 'url'=>array('index')),
	array('label'=>'Create Staff Job Type Rate', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#staff-job-type-rate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Staff Job Type Rates</h1>

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
	'id'=>'staff-job-type-rate-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
//		'staff_id',
                                    array(
                                        'name' => 'email',
                                        'value' => '$data->user->email',
                                    ),
                                    array(
                                        'name' => 'job_type_name',
                                        'value' => '$data->jobType->job_type_name',
                                    ),
//		'finance_job_type_id',
		'rate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
