<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */

$this->breadcrumbs=array(
	'Timesheets'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Timesheet', 'url'=>array('index')),
	array('label'=>'Create Timesheet', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#timesheet-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Time-sheets</h1>

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
	'id'=>'timesheet-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
                                    array(
                                        'name' => 'email',
                                        'value' => '$data->user->email',
                                    ),
//		'staff_id',
                                    array(
                                        'name' => 'hospital_unit',
                                        'value' => '$data->hospitalUnit->hospital_unit',
                                    ),
//		'hospital_unit_id',
//		'week_end_date',
                                    array(
                                            "name" => "invoice_date",
                                            "value" => 'Utility::changeDateToUK($data->invoice_date)',
                                    ),
                                    array(
                                            "name" => "week_end_date",
                                            "value" => 'Utility::changeDateToUK($data->week_end_date)',
                                    ),
                                    array(
                                        'name' => 'job_type_name',
                                        'value' => '$data->jobType->job_type_name',
                                    ),
//		'finance_job_type_id',
		'monday',
		'tuesday',
		'wednesday',
		'thursday',
		'friday',
		'saturday',
		'sunday',
		'total_worked_hours',
		'exp',
		'total_amount_of_staff',
		'total_amount_of_hospital',
		/*
		'note',
		'paid_to_staff',
		'paid_by_hospital',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
