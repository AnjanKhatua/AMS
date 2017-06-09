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
    array('label' => 'Manage Shift For Hospital', 'url' => array('admin')),
    array('label' => 'Manage Unfilled Shift', 'url' => array('adminUnfilled')),
    array('label' => 'Manage Archive Shift', 'url' => array('adminArchive')),
);

Yii::app()->clientScript->registerScript('search_self', "
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

<h1>Manage Shift Created By You</h1>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'shift-management-for-hospital-grid',
    'dataProvider' => $model->search_self(),
    'filter' => $model,
    'rowCssClassExpression' => '($data->quantity===$data->quantity_confirmed)? "green": ($row%2? "even": "odd")',
    'columns' => array(
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
        array(
            'header' => 'Action',
            'class' => 'CButtonColumn',
            'template' => '{update}{view}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => 'true',
                ),
                'view' => array(
                    'visible' => 'true',
                ),
                'delete' => array(
                    'visible' => 'Utility::checkLoginPerson($_SESSION[logged_user][type])',
                ),
            ),
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
?>
