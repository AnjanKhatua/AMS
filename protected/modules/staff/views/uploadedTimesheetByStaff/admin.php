<?php
/* @var $this UploadedTimesheetByStaffController */
/* @var $model UploadedTimesheetByStaff */

$this->breadcrumbs = array(
    'Uploaded Timesheet By Staff' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List Upload Timesheet By Staff', 'url'=>array('index')),
    array('label' => 'Create Upload Timesheet By Staff', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#uploaded-timesheet-by-staff-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Uploaded Timesheet By Staff</h1>

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
    'id' => 'uploaded-timesheet-by-staff-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
//        'staff_id',
        array(
            'name' => 'email',
            'value' => '$data->user->email',
        ),
        'ip',
//        'week_end_date',
        array(
            "name" => "week_end_date",
            "value" => 'Utility::changeDateToUK($data->week_end_date)',
        ),
//        'upload_date_time',
        array(
            "name" => "upload_date_time",
            "value" => 'Utility::changeDateToUK($data->upload_date_time)',
        ),
        'timesheet_name',
//        array(
//            'class' => 'CButtonColumn',
//        ),
    ),
));
?>
