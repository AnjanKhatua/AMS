<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Staff'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment Details For Staff', 'url'=>array('index')),
	array('label'=>'Create Timesheet Payment Details For Staff', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#timesheet-payment-details-for-staff-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Time-sheet Payment Details For Staff</h1>

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
	'id'=>'timesheet-payment-details-for-staff-grid',
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
                                        'name' => 'week_end_date',
                                        'value' => 'Utility::changeDateToUK($data->week_end_date)',
                                    ),
		'total_amount',
		'for_training_deduction',
		'payment_amount',
		/*
		'remaining_amount',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
