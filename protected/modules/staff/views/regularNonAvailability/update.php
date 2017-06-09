<?php
/* @var $this RegularNonAvailabilityController */
/* @var $model RegularNonAvailability */

$this->breadcrumbs=array(
	'Regular Non Availabilities'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Regular Non Availability', 'url'=>array('index')),
	array('label'=>'Create Regular Non Availability', 'url'=>array('create')),
	array('label'=>'View Regular Non Availability', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Regular Non Availability', 'url'=>array('admin')),
);
?>

<h1>Update RegularNonAvailability <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>