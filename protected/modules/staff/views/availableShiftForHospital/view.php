<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $model AvailableShiftForHospital */

$this->breadcrumbs = array(
    'Available Shift For Hospitals' => array('index'),
    $model->staff_request_id,
);

$this->menu = array(
//	array('label'=>'List Available Shift For Hospital', 'url'=>array('index')),
//    array('label' => 'Create Available Shift For Hospital', 'url' => array('create')),
//    array('label' => 'Update Available Shift For Hospital', 'url' => array('update', 'id' => $model->staff_request_id)),
//    array('label' => 'Delete Available Shift For Hospital', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->staff_request_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Available Shift For Hospital', 'url' => array('admin')),
);
?>

<h1>View Available Shift For Hospital</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'staff_request_id',
        array(
            "name" => "hospital_unit",
            "value" => $model->hospitalUnit->hospital_unit
        ),
        array(
            "name" => "ward_name",
            "value" => $model->ward->ward_name
        ),
        array(
            "name" => "job_type",
            "value" => $model->jobType->job_type
        ),
        'quantity',
        'quantity_confirmed',
        array("name" => "shift_start_datetime", "value" => Utility::changeDateToUK($model->shift_start_datetime)),
        array("name" => "shift_end_datetime", "value" => Utility::changeDateToUK($model->shift_end_datetime)),
//        array("name" => "requested_date", "value" => Utility::changeDateToUK($model->requested_date)),
//        'shift_start_datetime',
//        'shift_end_datetime',
//        'requested_date',
//        'requested_time',
//        'requested_person',
//        'request_accepted_by',
//        'requested_person_mobile_number',
        'status',
    ),
));
?>
