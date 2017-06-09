<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */

$this->breadcrumbs = array(
    'Shift For Hospitals' => array('index'),
    'Manage',
);

$this->menu = array(
    //array('label'=>'List ShiftManagementForHospital', 'url'=>array('index')),
    array('label' => 'Create Shift For Hospital', 'url' => array('create')),
    array('label' => 'Shift Created By You', 'url' => array('adminSelf')),
    array('label' => 'Manage Unfilled Shift', 'url' => array('adminUnfilled')),
    array('label' => 'Manage Archive Shift', 'url' => array('adminArchive')),
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

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<div id="error" class="errorMessage"></div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'booking-management-for-hospital',
//    'action' => Yii::app()->createUrl("admin/ShiftManagementForHospital/sendEnquiryAll"),
    'method' => 'post',
    'enableAjaxValidation' => false,
        ));
?>
<br>
<?php
echo CHtml::button('Send Enquiry', array(
        'submit' => array('ShiftManagementForHospital/sendEnquiryAll'),
        'confirm' => 'Are you sure to send enquery?'
    ));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'shift-management-for-hospital-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'rowCssClassExpression' => '($data->quantity===$data->quantity_confirmed)? "green": ($row%2? "even": "odd")',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('check_uncheck', false, array('value' => '', 'id' => 'checkUncheckAll')),
            'type' => 'raw',
            'value' => 'CHtml::checkBox("staff_request_id[]",false,array("id"=>"chkEnquery_".$data["staff_request_id"],"value" =>  $data["staff_request_id"], "class" => "staffIdChk"))'
        ),
        'staff_request_id',
        array(
            'name' => 'hospital_unit',
            'value' => '$data->hospitalUnit->hospital_unit',
        ),
        array(
            'name' => 'job_type',
            'value' => '$data->jobType->job_type',
        ),
//        array(
//            'name' => 'ward_name',
//            'value' => '$data->ward->ward_name',
//        ),
        'quantity',
        'quantity_confirmed',
        array("name" => "shift_start_datetime",
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'shift_start_datetime',
                'language' => 'en-GB',
                'htmlOptions' => array(
                    'id' => 'datepicker_for_shift_start_datetime',
                    'size' => '10',
                ),
                'options' => array(
                    'dateFormat' => 'dd-mm-yy',
                    'timeFormat' => 'hh:mm:ss',
                    'changeMonth' => true,
                    'changeYear' => true,
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;;background-color:#ffffff',
                    'readonly' => 'readonly',
                    'id' => 'shift_start_datetime',
                    'class' => 'datefieldfirst'
                ),
                    ), true),
            "value" => 'Utility::changeDateToUK($data->shift_start_datetime)'),
        array("name" => "shift_end_datetime",
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'shift_end_datetime',
                'language' => 'en-GB',
                'htmlOptions' => array(
                    'id' => 'datepicker_for_shift_end_datetime',
                    'size' => '10',
                ),
                'options' => array(
                    'dateFormat' => 'dd-mm-yy',
                    'timeFormat' => 'hh:mm:ss',
                    'changeMonth' => true,
                    'changeYear' => true,
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;;background-color:#ffffff',
                    'readonly' => 'readonly',
                    'id' => 'shift_end_datetime',
                    'class' => 'datefieldfirst'
                ),
                    ), true),
            "value" => 'Utility::changeDateToUK($data->shift_end_datetime)'),
//        array("name" => "requested_date", "value" => 'Utility::changeDateToUK($data->requested_date)'),
//        'requested_date',
//        'requested_time',
//        'requested_person',
        array(
            'name' => 'email',
            'value' => '$data->requestAcceptedBy->email',
        ),
//        'requested_person_mobile_number',
//        array(
//            'header' => 'Booking Notification',
//            'class' => 'CButtonColumn',
//            'template' => '{Mail}{or}{SMS}',
//            'buttons' => array
//                (
//                'Mail' => array
//                    (
//                    'label' => 'Mail',
//                    'url' => 'Yii::app()->createUrl("admin/ShiftManagementForHospital/SendSMSOrMail", array("id"=>$data->staff_request_id, "email"=>"email", "mobile"=>""))',
//                    'visible' => ' !Yii::app()->user->isGuest',
//                    'click' => "function(){ 
//                    var labelText = $(this).text();
//                    var obj = $(this);
//                  $.ajax({
//                            url: $(this).attr('href'),
//                            success: function() { 
//                                alert('Mail has been successfully sent');
//                        },
//                            error: function() { alert('Error in mail sending'); }
//                         }); return false;}"
//                ),
//                'or' => array
//                    (
//                    'label' => ' / ',
//                    'url' => '',
//                ),
//                'SMS' => array
//                    (
//                    'label' => 'SMS',
//                    'url' => 'Yii::app()->createUrl("admin/ShiftManagementForHospital/SendSMSOrMail", array("id"=>$data->staff_request_id, "email"=>"", "mobile"=>"mobile"))',
//                    'visible' => ' !Yii::app()->user->isGuest',
//                    'click' => "function(){ 
//                    var labelText = $(this).text();
//                    var obj = $(this);
//                  $.ajax({
//                            url: $(this).attr('href'),
//                            success: function() { 
//                                alert('SMS has been successfully sent');
//                        },
//                            error: function() { alert('Error in SMS sending'); }
//                         }); return false;}"
//                ),
//            ),
//        ),
//        
//        array(
//            'header' => 'Action',
//            'class' => 'CButtonColumn',
//            'template' => '{update}{view}{delete}',
//            'buttons' => array(
//                'update' => array(
//                    'visible' => 'true',
//                ),
//                'view' => array(
//                    'visible' => 'true',
//                ),
//                'delete' => array(
//                    'visible' => 'Utility::checkLoginPerson($_SESSION[logged_user][type])',
//                ),
//            ),
//        ),
        array(
            'header' => 'Action',
            'class' => 'CButtonColumn',
        ),
        array
            (
            'header' => 'Go To',
            'class' => 'CButtonColumn',
            'template' => '{quote}',
            'buttons' => array
                (
                'quote' => array
                    (
                    'label' => 'Manage Booking',
                    'url' => 'Yii::app()->createUrl("admin/shiftManagementForHospital/booking", array("id"=>$data->staff_request_id))',
                ),
            ),
        ),
    ),
));
$this->endWidget(); 
?>
