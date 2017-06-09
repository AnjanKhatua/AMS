<style>
    <!--
    table, tr, td, th {
        border:1px solid gray;
    }
    -->
</style>
<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */

$this->breadcrumbs = array(
    'Booking Management For Hospitals'
);

$this->menu = array(
    //array('label'=>'List ShiftManagementForHospital', 'url'=>array('index')),
    array('label' => 'Create Shift For Hospital', 'url' => array('create')),
    array('label' => 'Update Shift For Hospital', 'url' => array('update', 'id' => $model->staff_request_id)),
    array('label' => 'Delete Shift For Hospital', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->staff_request_id), 'confirm' => 'Are you sure you want to delete this item?'), 'visible' => Utility::checkLoginPerson($_SESSION[logged_user][type])),
    array('label' => 'Manage Shift For Hospital', 'url' => array('admin')),
);
?>

<h1>Booking Management For Hospitals</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'hospital_unit_id',
            'value' => $model->hospitalUnit->hospital_unit,
        ),
        array(
            'name' => 'job_type_id',
            'value' => $model->jobType->job_type,
        ),
        'quantity',
        'quantity_confirmed',
        'shift_start_datetime',
        'shift_end_datetime',
        'notes',
    ),
));
?>
<?php if (isset($_SESSION['errorInAssign']) && $_SESSION['errorInAssign'] != "") { ?>
    <span id="msgerrorInAssign"><?php echo $_SESSION['errorInAssign']; ?></span>
    <?php
    $_SESSION['errorInAssign'] = "";
}
?>
<br>
<h5><u>List of available staffs whom enquiry have not been sent</u></h5>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'booking-management-for-hospital-form',
//    'action' => Yii::app()->createUrl("admin/ShiftManagementForHospital/sendEnquiry"),
    'method' => 'post',
    'enableAjaxValidation' => false,
        ));
?>

Note : 
<div><div class="colorDetailsForGreen">
    </div> <div>: Staff previously worked in this hospital.</div></div>
<div><div class="colorDetailsForRed">
    </div> <div>: Staff expired training duration.</div></div>
<div id="error" class="errorMessage"></div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'booking-management-for-hospital-grid',
    'dataProvider' => $model_staff,
    //'filter'=>$model_confirmed_staff,
    'rowCssClassExpression' => '($data["flag"]===1)? "green": ($row%2? "even": "odd")',
//    'rowCssClassExpression' => '($data["flagForExpiry"]===1)? "redFont": (($data["flag"]===1)? "green": ($row%2? "even": "odd"))',
//    'rowCssClassExpression' => '($data["flagForExpiry"]===1)? "red": (($data["flag"]===1)? "green": ($row%2? "even": "odd"))',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('check_uncheck', false, array('value' => '', 'id' => 'checkUncheckAll')),
            'type' => 'raw',
            'value' => 'CHtml::checkBox("staff_ids[]",false,array("id"=>"chkEnquery_".$data["staff_id"],"value" =>  $data["0"], "class" => "staffIdChk"))'
        ),
        array(
            'name' => 'Staff Name',
            'value' => '$data["first_name"]',
            'type' => 'text',
            'cssClassExpression' => '$data["flagForExpiry"] == 1 ? "redFont" : ""'
        ),
        array(
            'name' => 'Worked Hours',
            'value' => '$data["allowed_hours"]',
            'type' => 'text',
            'cssClassExpression' => '$data["flagForExpiry"] == 1 ? "redFont" : ""'
        ),
        array(
            'name' => 'Maximum allowed hours',
            'value' => '$data["max_allowed_hour"]',
            'type' => 'text',
            'cssClassExpression' => '$data["flagForExpiry"] == 1 ? "redFont" : ""'
        ),
        array(
            'name' => 'Contact Number',
            'value' => '$data["mobile_no"]',
            'type' => 'text',
            'cssClassExpression' => '$data["flagForExpiry"] == 1 ? "redFont" : ""'
        ),
        array(
            'name' => 'Email',
            'value' => '$data["email"]',
            'type' => 'text',
            'cssClassExpression' => '$data["flagForExpiry"] == 1 ? "redFont" : ""'
        ),
    ),
));
?>
<input type="hidden" name="staff_request_id" value="<?php echo $model->staff_request_id; ?>">
<input type="hidden" name="enquired_by" value="<?php echo $_SESSION['logged_user']['id']; ?>">
<?php // echo CHtml::submitButton("Send Enquiry", array('id' => 'send_enquiry', 'name' => 'enquiry'));  ?>
<?php // echo CHtml::submitButton("Confirm Availability", array('id' => 'confirm_availability', 'name' => 'availability')); ?>
<?php // echo CHtml::submitButton("Confirm Booking", array('id' => 'confirm_booking', 'name' => 'booking')); ?>

<?php
if ($lf_checkExpiry == 1) {
    echo CHtml::button('Send Enquiry', array(
        'submit' => array('ShiftManagementForHospital/sendEnquiry'),
        'confirm' => 'Are you sure to send enquery?'
    ));

    echo CHtml::button('Confirm Availability', array(
        'submit' => array('ShiftManagementForHospital/directAllocation'),
        'confirm' => 'Are you sure to allocation?'
    ));

    echo CHtml::button('Confirm Booking', array(
        'submit' => array('ShiftManagementForHospital/directConfirmation'),
        'confirm' => 'Are you sure to booking?'
    ));
}
?>


<?php $this->endWidget(); ?>

<h5><u>List of available staffs whom enquiry have been sent but they have not confirmed</u></h5>
<?php
//$form = $this->beginWidget('CActiveForm', array(
//    'id' => 'confirmed-hospital-form',
//    'action' => '/agencyManagementSystem/index.php?r=admin/ShiftManagementForHospital/confirm',
//    'action' => Yii::app()->createUrl("admin/ShiftManagementForHospital/confirm", array("id"=>$model->staff_request_id, "sid" => $data["staff_id"])),
//    'enableAjaxValidation' => false,
//        ));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'confirmed-staff-management-for-hospital-grid',
    'dataProvider' => $model_not_confirmed_staff,
    //'filter'=>$model_confirmed_staff,
    'columns' => array(
        array(
            'name' => 'Staff Name',
            'value' => '$data["first_name"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Worked Hours',
            'value' => '$data["allowed_hours"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Maximum allowed hours',
            'value' => '$data["max_allowed_hour"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Contact Number',
            'value' => '$data["mobile_no"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Email',
            'value' => '$data["email"]',
            'type' => 'text'
        ),
        array(
            'header' => 'Enquired By',
            'name' => 'confirmed_by',
            'value' => function($data, $row) {
                if ($data['confirmed_by'] == 'A') {
                    $status = "Admin";
                } else if ($data['confirmed_by'] == 'C') {
                    $status = "Coordinator";
                } else if ($data['confirmed_by'] == 'M') {
                    $status = "Manager";
                } else if ($data['confirmed_by'] == 'S') {
                    $status = "Staff";
                } else if ($data['confirmed_by'] == 'NA') {
                    $status = "Not Applicable";
                }
                return $status;
            },
        ),
        array(
            'name' => 'Availability confirmed by staff',
            'value' => '$data["availability_confirmed_by_staff"]==\'Y\' ? \'Yes\' : \'No\'',
            'type' => 'text'
        ),
        array(
            'header' => 'Confirm',
            'name' => 'is_confirmed',
            'value' => '$data["is_confirmed"]==\'Y\' ? \'Yes\' : \'No\'', //in the case we want something custom
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{want to confirm?}',
            'buttons' => array
                (
                'want to confirm?' => array
                    (
                    'label' => 'Confirmed that shift?',
                    'url' => 'Yii::app()->createUrl("admin/shiftManagementForHospital/allocate", array("id"=>$data["staff_request_id"], "staffId" => $data["staff_id"]))',
                    'visible' => "$lf_checkExpiry",
                ),
            ),
        ),
    ),
));
?>
<h5><u>List of available staffs who have confirmed their availability</u></h5>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'confirmed-staff-management-for-hospital-grid',
    'dataProvider' => $model_confirmed_staff,
    //'filter'=>$model_confirmed_staff,
    'columns' => array(
        array(
            'name' => 'Staff Name',
            'value' => '$data["first_name"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Worked Hours',
            'value' => '$data["allowed_hours"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Maximum allowed hours',
            'value' => '$data["max_allowed_hour"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Contact Number',
            'value' => '$data["mobile_no"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Email',
            'value' => '$data["email"]',
            'type' => 'text'
        ),
        array(
            'header' => 'Enquired By',
            'name' => 'confirmed_by',
            'value' => function($data, $row) {
                if ($data['confirmed_by'] == 'A') {
                    $status = "Admin";
                } else if ($data['confirmed_by'] == 'C') {
                    $status = "Coordinator";
                } else if ($data['confirmed_by'] == 'M') {
                    $status = "Manager";
                } else if ($data['confirmed_by'] == 'S') {
                    $status = "Staff";
                } else if ($data['confirmed_by'] == 'NA') {
                    $status = "Not Applicable";
                }
                return $status;
            },
        ),
        array(
            'name' => 'Availability confirmed by staff',
            'value' => '$data["availability_confirmed_by_staff"]==\'Y\' ? \'Yes\' : \'No\'',
            'type' => 'text'
        ),
        array(
            'header' => 'Confirm',
            'name' => 'is_confirmed',
            'value' => '$data["is_confirmed"]==\'Y\' ? \'Yes\' : \'No\'', //in the case we want something custom
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{Allocation}',
            'buttons' => array
                (
                'Allocation' => array
                    (
                    'label' => 'Allocate for shift',
                    'url' => 'Yii::app()->createUrl("admin/shiftManagementForHospital/confirm", array("id"=>$data["staff_request_id"], "staffId" => $data["staff_id"]))',
                    'visible' => "$lf_checkExpiry",
                ),
            ),
        ),
    ),
));
?>

<h5><u>List of booked staff for this shift</u></h5>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'confirmed-staff-management-for-hospital-grid',
    'dataProvider' => $model_booked_staff,
    //'filter'=>$model_confirmed_staff,
    'columns' => array(
        array(
            'name' => 'Staff Name',
            'value' => '$data["first_name"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Maximum allowed hours',
            'value' => '$data["max_allowed_hour"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Contact Number',
            'value' => '$data["mobile_no"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Email',
            'value' => '$data["email"]',
            'type' => 'text'
        ),
        array(
            'header' => 'Enquired By',
            'name' => 'confirmed_by',
            'value' => function($data, $row) {
                if ($data['confirmed_by'] == 'A') {
                    $status = "Admin";
                } else if ($data['confirmed_by'] == 'C') {
                    $status = "Coordinator";
                } else if ($data['confirmed_by'] == 'M') {
                    $status = "Manager";
                } else if ($data['confirmed_by'] == 'S') {
                    $status = "Staff";
                } else if ($data['confirmed_by'] == 'NA') {
                    $status = "Not Applicable";
                }
                return $status;
            },
        ),
        array(
            'name' => 'Availability confirmed by staff',
            'value' => '$data["availability_confirmed_by_staff"]==\'Y\' ? \'Yes\' : \'No\'',
            'type' => 'text'
        ),
        array(
            'header' => 'Confirm',
            'name' => 'is_confirmed',
            'value' => '$data["is_confirmed"]==\'Y\' ? \'Yes\' : \'No\'', //in the case we want something custom
        ),
        array(
            'header' => 'Booking Notification',
            'class' => 'CButtonColumn',
            'template' => '{SMS}',
            'buttons' => array
                (
                'SMS' => array
                    (
                    'label' => 'Send SMS',
                    'url' => 'Yii::app()->createUrl("admin/ShiftManagementForHospital/SendSMS", array("id"=>$data["staff_request_id"], "staffId" => $data["staff_id"]))',
                    'visible' => ' !Yii::app()->user->isGuest',
                    'click' => "function(){ 
                    var labelText = $(this).text();
                    var obj = $(this);
                  $.ajax({
                            url: $(this).attr('href'),
                            success: function() { 
                                alert('SMS has been successfully sent');
                        },
                            error: function() { alert('Error in SMS sending'); }
                         }); return false;}"
                ),
            ),
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{Rejection}',
            'buttons' => array
                (
                'Rejection' => array
                    (
                    'label' => 'Rejection',
                    'url' => 'Yii::app()->createUrl("admin/shiftManagementForHospital/cancel", array("id"=>$data["staff_request_id"], "staffId" => $data["staff_id"]))',
                    'visible' => "$lf_checkExpiry",
                ),
            ),
        ),
    ),
));
?>

<h5><u>Cancelled staff list after confirmation for that shift</u></h5>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'confirmed-staff-management-for-hospital-grid',
    'dataProvider' => $model_cancel_after_confirmed_shift,
    //'filter'=>$model_confirmed_staff,
    'columns' => array(
        array(
            'name' => 'Staff Name',
            'value' => '$data["first_name"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Maximum allowed hours',
            'value' => '$data["max_allowed_hour"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Contact Number',
            'value' => '$data["mobile_no"]',
            'type' => 'text'
        ),
        array(
            'name' => 'Email',
            'value' => '$data["email"]',
            'type' => 'text'
        ),
        array(
            'header' => 'Enquired By',
            'name' => 'confirmed_by',
            'value' => function($data, $row) {
                if ($data['confirmed_by'] == 'A') {
                    $status = "Admin";
                } else if ($data['confirmed_by'] == 'C') {
                    $status = "Coordinator";
                } else if ($data['confirmed_by'] == 'M') {
                    $status = "Manager";
                } else if ($data['confirmed_by'] == 'S') {
                    $status = "Staff";
                } else if ($data['confirmed_by'] == 'NA') {
                    $status = "Not Applicable";
                }
                return $status;
            },
        ),
        array(
            'name' => 'Availability confirmed by staff',
            'value' => '$data["availability_confirmed_by_staff"]==\'Y\' ? \'Yes\' : \'No\'',
            'type' => 'text'
        ),
        array(
            'header' => 'Confirm',
            'name' => 'is_confirmed',
            'value' => '$data["is_confirmed"]==\'Y\' ? \'Yes\' : \'No\'', //in the case we want something custom
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{Allocation}',
            'buttons' => array
                (
                'Allocation' => array
                    (
                    'label' => 'Want to allocate again?',
                    'url' => 'Yii::app()->createUrl("admin/shiftManagementForHospital/againconfirm", array("id"=>$data["staff_request_id"], "staffId" => $data["staff_id"]))',
//                    'visible' => 'Utility::checkBookingApplyStatus($data["staff_request_id"], $data["staff_id"])'
//                    'visible' => 'Utility::checkShiftExpiryStatus($data["shift_start_datetime"])'
                    'visible' => "$lf_checkExpiry",
                ),
            ),
        ),
    ),
));
?>

