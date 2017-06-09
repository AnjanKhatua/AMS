<?php
/* @var $this TrainingDetailsController */
/* @var $model TrainingDetails */

$this->breadcrumbs=array(
	'Training Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Training Details', 'url'=>array('index')),
	array('label'=>'Create Training Details', 'url'=>array('create')),
	array('label'=>'View Training Details', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Training Details', 'url'=>array('admin')),
);
?>

<h1>Update Training Details <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>