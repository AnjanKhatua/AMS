<?php
/* @var $this TimesheetPaymentDetailsForHospitalController */
/* @var $model TimesheetPaymentDetailsForHospital */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Hospitals'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment For Hospital', 'url'=>array('index')),
	array('label'=>'Create Timesheet Payment For Hospital', 'url'=>array('create')),
	array('label'=>'Update Timesheet Payment For Hospital', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Timesheet Payment For Hospital', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Timesheet Payment For Hospital', 'url'=>array('admin')),
);
?>

<h1>View Time-sheet Payment Details For Hospital #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
//		'hospital_unit_id',
                                    array(
                                        'name' => 'hospital_unit',
                                        'value' => $model->hospitalUnit->hospital_unit,
                                    ),
		array(
                                        'name' => 'week_end_date',
                                        'value' => Utility::changeDateToUK($model->week_end_date),
                                    ),
		'total_amount',
		'payment_amount',
		'remaining_amount',
	),
)); ?>
