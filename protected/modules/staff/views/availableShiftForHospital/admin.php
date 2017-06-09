<?php
/* @var $this AvailableShiftForHospitalController */
/* @var $model AvailableShiftForHospital */

$this->breadcrumbs = array(
    'Available Shift For Hospitals' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List Available Shift For Hospital', 'url'=>array('index')),
//                  array('label' => 'Create Available Shift For Hospital', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#available-shift-for-hospital-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Upcoming available shifts</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

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
    'id' => 'available-shift-for-hospital-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
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
        array(
            'name' => 'ward_name',
            'value' => '$data->ward->ward_name',
        ),
        'quantity',
        'quantity_confirmed',
        array("name" => "shift_start_datetime", "value" => 'Utility::changeDateToUK($data->shift_start_datetime)'),
        array("name" => "shift_end_datetime", "value" => 'Utility::changeDateToUK($data->shift_end_datetime)'),
        /*
          'requested_date',
          'requested_time',
          'requested_person',
          'request_accepted_by',
          'requested_person_mobile_number',
          'status',
         */
//        array(
//            'class' => 'CButtonColumn',
//        ),

        array(
            'class' => 'CButtonColumn',
            'template' => '{quote}',
            'buttons' => array
                (
                'quote' => array
                    (
                    'label' => 'View Details',
                    'url' => 'Yii::app()->createUrl("staff/availableShiftForHospital/view", array("id"=>$data->staff_request_id))',
                     'visible' =>' !Yii::app()->user->isGuest'
                ),
            ),
        ),

        
        array(
            'class' => 'CButtonColumn',
            'template' => '{apply}{cancel}',
            'buttons' => array
                (
                'apply' => array
                    (
                    'label' => 'Apply',
                    'url' =>  'Yii::app()->createUrl("staff/ShiftEnquiry/shiftApplyOrCancel", array("id"=>$data->staff_request_id))',
                   'visible' => 'Utility::checkApplyStatus($data->staff_request_id, $_SESSION[logged_user][id])',
                    'click' => "function(){ 
                    var labelText = $(this).text();
                    var obj = $(this);
                  $.ajax({
                            url: $(this).attr('href'),
                            success: function() { 
                        
                            if(labelText=='Apply')     
                                    $(obj).text('Cancel');
                            else
                                    $(obj).text('Apply');
                        },
                            error: function() { alert('Ajax button failed'); }
                         }); return false;}"
                ),
                
                 'cancel' => array
                    (
                  'label' => 'Cancel',
                    'url' =>  'Yii::app()->createUrl("staff/ShiftEnquiry/shiftApplyOrCancel", array("id"=>$data->staff_request_id))',
                    'visible' => '!Utility::checkApplyStatus($data->staff_request_id, $_SESSION[logged_user][id])',
                    'click' => "function(){ 
                    var labelText = $(this).text();
                    var obj = $(this);
                  $.ajax({
                            url: $(this).attr('href'),
                            success: function() { 
                        
                            if(labelText=='Apply')     
                                    $(obj).text('Cancel');
                            else
                                    $(obj).text('Apply');
                        },
                            error: function() { alert('Ajax button failed'); }
                         }); return false;}"
                ),
            ),
        ),        
    ),
));
?>
