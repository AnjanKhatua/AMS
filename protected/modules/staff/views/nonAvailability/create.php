<?php
/* @var $this NonAvailabilityController */
/* @var $model NonAvailability */

$this->breadcrumbs=array(
	'Non Availabilities'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Non Availability', 'url'=>array('index')),
	array('label'=>'Manage Non Availability', 'url'=>array('admin')),
);
?>

<h1>Create Non Availability</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'chkData' => $chkData, 'chkData1' => $chkData1)); ?>