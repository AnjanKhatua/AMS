<?php
/* @var $this TimesheetPaymentDetailsForHospitalController */
/* @var $model TimesheetPaymentDetailsForHospital */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Hospitals'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment For Hospital', 'url'=>array('index')),
	array('label'=>'Create Timesheet Payment For Hospital', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#timesheet-payment-details-for-hospital-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Timesheet Payment Details For Hospitals</h1>

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
	'id'=>'timesheet-payment-details-for-hospital-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
//		'hospital_unit_id',
                                    array(
                                        'name' => 'hospital_unit',
                                        'value' => '$data->hospitalUnit->hospital_unit',
                                    ),
		array(
                                        'name' => 'week_end_date',
                                        'value' => 'Utility::changeDateToUK($data->week_end_date)',
                                    ),
		'total_amount',
		'payment_amount',
//		'remaining_amount',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
