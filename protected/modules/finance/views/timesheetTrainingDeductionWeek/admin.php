<?php
/* @var $this TimesheetTrainingDeductionWeekController */
/* @var $model TimesheetTrainingDeductionWeek */

$this->breadcrumbs=array(
	'Timesheet Training Deduction Weeks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TimesheetTrainingDeductionWeek', 'url'=>array('index')),
	array('label'=>'Create TimesheetTrainingDeductionWeek', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#timesheet-training-deduction-week-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Timesheet Training Deduction Weeks</h1>

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
	'id'=>'timesheet-training-deduction-week-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'staff_id',
		'invoice_date',
		'week_end_date',
		'apply_status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
