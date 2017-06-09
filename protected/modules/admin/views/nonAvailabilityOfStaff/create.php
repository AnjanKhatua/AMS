<?php
/* @var $this NonAvailabilityOfStaffController */
/* @var $model NonAvailabilityOfStaff */

$this->breadcrumbs=array(
	'Non Availability Of Staff'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NonAvailabilityOfStaff', 'url'=>array('index')),
	array('label'=>'Manage NonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>Create NonAvailabilityOfStaff</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>