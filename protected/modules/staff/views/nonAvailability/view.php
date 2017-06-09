<?php
/* @var $this NonAvailabilityController */
/* @var $model NonAvailability */

$this->breadcrumbs=array(
	'Non Availabilities'=>array('index'),
	$model->non_availablility_id,
);

$this->menu=array(
//	array('label'=>'List Non Availability', 'url'=>array('index')),
	array('label'=>'Create Non Availability', 'url'=>array('create')),
	array('label'=>'Update Non Availability', 'url'=>array('update', 'id'=>$model->non_availablility_id)),
	array('label'=>'Delete Non Availability', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->non_availablility_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Non Availability', 'url'=>array('admin')),
);
?>

<h1>View Non Availability #<?php echo $model->non_availablility_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'non_availablility_id',
                                        array(
                                            "name" => "staff_id",
                                            "value" => $model->staff->last_name
                                        ),
                                        array("name"=>"start_date","value"=>Utility::changeDateToUK($model->start_date)),
                                        array("name"=>"end_date","value"=>Utility::changeDateToUK($model->end_date)),
		'start_time',
		'end_time',
	),
)); ?>
