<?php
/* @var $this RegularNonAvailabilityController */
/* @var $model RegularNonAvailability */

$this->breadcrumbs=array(
	'Regular Non Availabilities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Regular Non Availability', 'url'=>array('index')),
	array('label'=>'Manage Regular Non Availability', 'url'=>array('admin')),
);
?>

<h1>Create RegularNonAvailability</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>