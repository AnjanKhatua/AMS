<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */

$this->breadcrumbs=array(
	'Timesheet Payment Details For Staff'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Timesheet Payment Details For Staff', 'url'=>array('index')),
	array('label'=>'Create Timesheet Payment Details For Staff', 'url'=>array('create')),
	array('label'=>'Update Timesheet Payment Details For Staff', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Timesheet Payment Details For Staff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Timesheet Payment Details For Staff', 'url'=>array('admin')),
);
?>

<h1>View Time-sheet Payment Details For Staff #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
//		'staff_id',
                                    array(
                                        'name' => 'email',
                                        'value' => $model->user->email,
                                    ),
		array(
                                        'name' => 'week_end_date',
                                        'value' => Utility::changeDateToUK($model->week_end_date),
                                    ),
		'total_amount',
		'for_training_deduction',
		'payment_amount',
		'remaining_amount',
	),
)); ?>
