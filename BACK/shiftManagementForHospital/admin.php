<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */

$this->breadcrumbs=array(
	'Shift For Hospitals'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List ShiftManagementForHospital', 'url'=>array('index')),
	array('label'=>'Create Shift For Hospital', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shift-management-for-hospital-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Shift For Hospitals</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shift-management-for-hospital-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'staff_request_id',
		
		array(
			'name'=>'hospital_unit_id',
			'value'=>'$data->hospitalUnit->hospital_unit',
		),
		array(
			'name'=>'job_type_id',
			'value'=>'$data->jobType->job_type',
		),
		
		'quantity',
		'date',
		'shift_start_time',
		'shift_end_time',
		'requested_date',
		'requested_time',
		'requested_person',
		
		array(
			'name'=>'request_accepted_by',
			'value'=>'$data->requestAcceptedBy->first_name',
		),
		'requested_person_mobile_number',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
