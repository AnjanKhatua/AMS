<?php
/* @var $this ServiceCompletedController */
/* @var $model ServiceCompleted */

$this->breadcrumbs=array(
	'Service Completeds'=>array('index'),
	$model->service_id=>array('view','id'=>$model->service_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceCompleted', 'url'=>array('index')),
	array('label'=>'Create ServiceCompleted', 'url'=>array('create')),
	array('label'=>'View ServiceCompleted', 'url'=>array('view', 'id'=>$model->service_id)),
	array('label'=>'Manage ServiceCompleted', 'url'=>array('admin')),
);
?>

<h1>Update ServiceCompleted <?php echo $model->service_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>