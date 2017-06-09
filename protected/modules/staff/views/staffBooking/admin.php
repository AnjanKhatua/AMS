<?php
/* @var $this StaffBookingController */
/* @var $model StaffBooking */

$this->breadcrumbs = array(
    'Staff Bookings' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List Staff Booking', 'url'=>array('index')),
//	array('label'=>'Create Staff Booking', 'url'=>array('create')),
        //array('label'=>'Preview Previous Booking', 'url'=>array('adminPrevious')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#staff-booking-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Upcoming confirmed shifts</h1>

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
    'id' => 'staff-booking-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
//		'booking_id',
//		'staff_request_id',
        array(
            'name' => 'first_name',
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
        /*
          'confirmation_date',
          'confirmation_time',
          'confirm_by_whom',
          'cancellation_date',
          'cancellation_time',
          'cancel_by_whom',
          'cancel_requested_by',
         */
        array(
            'class' => 'CButtonColumn',
            'template' => '{quote}',
            'buttons' => array
                (
                'quote' => array
                    (
                    'label' => 'View Details',
                    'url' => 'Yii::app()->createUrl("staff/staffBooking/view", array("id"=>$data->booking_id))',
                    'visible' => ' !Yii::app()->user->isGuest'
                ),
            ),
        ),
    ),
));
?>
