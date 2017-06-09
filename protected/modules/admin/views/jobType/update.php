<?php
/* @var $this JobTypeController */
/* @var $model JobType */

$this->breadcrumbs=array(
	'Job Types'=>array('index'),
	$model->job_type_id=>array('view','id'=>$model->job_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JobType', 'url'=>array('index')),
	array('label'=>'Create JobType', 'url'=>array('create')),
	array('label'=>'View JobType', 'url'=>array('view', 'id'=>$model->job_type_id)),
	array('label'=>'Manage JobType', 'url'=>array('admin')),
);
?>

<h1>Update Job Type <?php echo $model->job_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>