<?php
/* @var $this JobTypeForFinanceController */
/* @var $model JobTypeForFinance */

$this->breadcrumbs=array(
	'Job Type For Finances'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Job Type For Finance', 'url'=>array('index')),
	array('label'=>'Create Job Type For Finance', 'url'=>array('create')),
	array('label'=>'Update Job Type For Finance', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Job Type For Finance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Job Type For Finance', 'url'=>array('admin')),
);
?>

<h1>View Job Type For Finance #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
//		'job_type_id',
                                    array(
                                        'name' => 'job_type_id',
                                        'value' => $model->jobType->job_type,
                                    ),
		'job_type_name',
		'status',
	),
)); ?>
