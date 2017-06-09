<?php
/* @var $this JobTypeController */
/* @var $model JobType */

$this->breadcrumbs=array(
	'Job Types'=>array('index'),
	$model->job_type_id,
);

$this->menu=array(
	array('label'=>'List JobType', 'url'=>array('index')),
	array('label'=>'Create JobType', 'url'=>array('create')),
	array('label'=>'Update JobType', 'url'=>array('update', 'id'=>$model->job_type_id)),
	array('label'=>'Delete JobType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->job_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JobType', 'url'=>array('admin')),
);
?>

<h1>View Job Type #<?php echo $model->job_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'job_type_id',
		'job_type',
		'job_type_active_status',
	),
)); ?>
