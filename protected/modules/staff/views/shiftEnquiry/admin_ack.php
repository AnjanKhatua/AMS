<?php
/* @var $this ShiftEnquiryController */
/* @var $model ShiftEnquiry */

$this->breadcrumbs = array(
    'Shift Enquiries' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List Shift Enquiry', 'url'=>array('index')),
//    array('label' => 'Create Shift Enquiry', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search_ack', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shift-enquiry-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Enquired shift for you</h1>

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
    'id' => 'shift-enquiry-grid',
    'dataProvider' => $model->search_ack(),
    'filter' => $model,
    'columns' => array(
//		'enquiry_id',
        'staff_request_id',
//        'staff_id',
//        'enquired_by',
        array(
            'name' => 'enquired_by',
            'value' => '$data->user->first_name',
        ),
        array(
            'name' => 'hospital_unit_id',
            'value' => '$data->staffRequest->hospitalUnit->hospital_unit',
        ),
        array(
            'name' => 'job_type_id',
            'value' => '$data->staffRequest->jobType->job_type',
        ),
        array(
            'name' => 'ward_id',
            'value' => '$data->staffRequest->ward->ward_name',
        ),
        array(
            'name' => 'shift_start_datetime',
            'value' => 'Utility::changeDateToUK($data->staffRequest->shift_start_datetime)',
        ),
        array(
            'name' => 'shift_end_datetime',
            'value' => 'Utility::changeDateToUK($data->staffRequest->shift_end_datetime)',
        ),
        array("name" => "availability_confirmed_by_staff", "value" => 'Utility::checkStatus($data->availability_confirmed_by_staff)'),
        'availability_confirmed_via',
//        'confirmed_by',
//        'agent_user_id',
//        'is_confirmed',
        array("name" => "is_confirmed", "value" => 'Utility::checkStatus($data->is_confirmed)'),
//        array(
//                'class'=>'CButtonColumn',
//        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{View}{or}{Update}',
            'buttons' => array
                (
                'View' => array
                    (
                    'label' => 'View',
                    'url' => 'Yii::app()->createUrl("staff/shiftEnquiry/view", array("id"=>$data->enquiry_id))',
                    'visible' => ' !Yii::app()->user->isGuest'
                ),
                'or' => array
                    (
                    'label' => ' / ',
                    'url' => '',
                ),
                'Update' => array
                    (
                    'label' => 'Update',
                    'url' => 'Yii::app()->createUrl("staff/shiftEnquiry/update", array("id"=>$data->enquiry_id))',
                    'visible' => ' !Yii::app()->user->isGuest'
                ),
            ),
        ),
    ),
));
?>
