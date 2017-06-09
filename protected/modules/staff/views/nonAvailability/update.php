<?php
/* @var $this NonAvailabilityController */
/* @var $model NonAvailability */

$this->breadcrumbs=array(
	'Non Availabilities'=>array('index'),
	$model->non_availablility_id=>array('view','id'=>$model->non_availablility_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Non Availability', 'url'=>array('index')),
	array('label'=>'Create Non Availability', 'url'=>array('create')),
	array('label'=>'View Non Availability', 'url'=>array('view', 'id'=>$model->non_availablility_id)),
	array('label'=>'Manage Non Availability', 'url'=>array('admin')),
);
?>

<h1>Update Non Availability <?php echo $model->non_availablility_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'chkData' => $chkData, 'chkData1' => $chkData1)); ?>