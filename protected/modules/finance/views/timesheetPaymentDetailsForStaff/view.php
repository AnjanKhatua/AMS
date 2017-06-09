<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */

$this->breadcrumbs = array(
    'Timesheet Payment Details For Staff' => array('index'),
    $model->id,
);

$this->menu = array(
//    array('label' => 'List Timesheet Payment Details For Staff', 'url' => array('index')),
//    array('label' => 'Create Timesheet Payment Details For Staff', 'url' => array('create')),
//    array('label' => 'Update Timesheet Payment Details For Staff', 'url' => array('update', 'id' => $model->id)),
//    array('label' => 'Delete Timesheet Payment Details For Staff', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Timesheet Payment Details For Staff', 'url' => array('admin')),
);
?>

<h1>View Time-sheet Payment Details For Staff #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
//        'staff_id',
//        'invoice_date',
//        'week_end_date',
        array(
            'name' => 'first_name',
            'value' => $model->user->first_name,
        ),
        array(
            'name' => 'last_name',
            'value' => $model->user->last_name,
        ),
        array(
            'name' => 'invoice_date',
            'value' => Utility::changeDateToUK($model->invoice_date),
        ),
        array(
            'name' => 'week_end_date',
            'value' => Utility::changeDateToUK($model->week_end_date),
        ),
        'total_amount',
        'training_deduction_amount',
        'net_amount',
//        'training_deduction_apply',
//        'paid_status',
        array(
            'name' => 'training_deduction_apply',
            'value' => function($data) {
                if ($data->training_deduction_apply == 'Y') {
                    $status = "Yes";
                } else if ($data->training_deduction_apply == 'N') {
                    $status = "No";
                }
                return $status;
            },
            'type' => 'text',
        ),
        array(
            'name' => 'paid_status',
            'value' => function($data) {
                if ($data->paid_status == 'Y') {
                    $status = "Yes";
                } else if ($data->paid_status == 'N') {
                    $status = "No";
                }
                return $status;
            },
            'type' => 'text',
        ),
    ),
));
?>
