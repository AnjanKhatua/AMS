<?php
/* @var $this RegularNonAvailabilityOfStaffController */
/* @var $model RegularNonAvailabilityOfStaff */

$this->breadcrumbs=array(
	'Regular Non Availability Of Staff'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegularNonAvailabilityOfStaff', 'url'=>array('index')),
	array('label'=>'Create RegularNonAvailabilityOfStaff', 'url'=>array('create')),
	array('label'=>'View RegularNonAvailabilityOfStaff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RegularNonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>Update RegularNonAvailabilityOfStaff <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>