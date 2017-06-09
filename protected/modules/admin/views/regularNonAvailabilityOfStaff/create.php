<?php
/* @var $this RegularNonAvailabilityOfStaffController */
/* @var $model RegularNonAvailabilityOfStaff */

$this->breadcrumbs=array(
	'Regular Non Availability Of Staff'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegularNonAvailabilityOfStaff', 'url'=>array('index')),
	array('label'=>'Manage RegularNonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>Create RegularNonAvailabilityOfStaff</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>