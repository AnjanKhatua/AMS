<?php
/* @var $this NonAvailabilityOfStaffController */
/* @var $model NonAvailabilityOfStaff */

$this->breadcrumbs=array(
	'Non Availability Of Staff'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NonAvailabilityOfStaff', 'url'=>array('index')),
	array('label'=>'Create NonAvailabilityOfStaff', 'url'=>array('create')),
	array('label'=>'View NonAvailabilityOfStaff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NonAvailabilityOfStaff', 'url'=>array('admin')),
);
?>

<h1>Update NonAvailabilityOfStaff <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>