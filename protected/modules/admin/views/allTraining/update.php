<?php
/* @var $this AllTrainingController */
/* @var $model AllTraining */

$this->breadcrumbs=array(
	'All Trainings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Training', 'url'=>array('index')),
	array('label'=>'Create Training', 'url'=>array('create')),
	array('label'=>'View Training', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Training', 'url'=>array('admin')),
);
?>

<h1>Update Training <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>