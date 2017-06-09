<?php
/* @var $this TimesheetController */
/* @var $model Timesheet */

$this->breadcrumbs = array(
    'Timesheets' => array('index'),
    $model->id,
);

$this->menu = array(
//	array('label'=>'List Timesheet', 'url'=>array('index')),
    array('label' => 'Create Timesheet', 'url' => array('create')),
    array('label' => 'Update Timesheet', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Timesheet', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Timesheet', 'url' => array('admin')),
);
?>

<h1>View Time-sheet #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
//		'staff_id',
        array(
            'name' => 'first_name',
            'value' => $model->user->first_name,
        ),
        array(
            'name' => 'last_name',
            'value' => $model->user->last_name,
        ),
//		'hospital_unit_id',
        array(
            'name' => 'hospital_unit',
            'value' => $model->hospitalUnit->hospital_unit,
        ),
        array(
            'name' => 'invoice_date',
            'value' => Utility::changeDateToUK($model->invoice_date),
        ),
        array(
            'name' => 'week_end_date',
            'value' => Utility::changeDateToUK($model->week_end_date),
        ),
//                                  'invoice_date',
//		'week_end_date',
//		'finance_job_type_id',
        array(
            'name' => 'job_type_name',
            'value' => $model->jobType->job_type_name,
        ),
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
        'note',
        'paid_to_staff',
        'paid_by_hospital',
    ),
));
?>
