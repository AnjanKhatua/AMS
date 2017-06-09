<?php
/* @var $this StaffJobTypeRateController */
/* @var $model StaffJobTypeRate */

$this->breadcrumbs=array(
	'Staff Job Type Rates'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Staff Job Type Rate', 'url'=>array('index')),
	array('label'=>'Create Staff Job Type Rate', 'url'=>array('create')),
	array('label'=>'Update Staff Job Type Rate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Staff Job Type Rate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Staff Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>View Staff Job Type Rate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
//		'staff_id',
                                    array(
                                        'name' => 'email',
                                        'value' => $model->user->email,
                                    ),
                                    array(
                                        'name' => 'job_type_name',
                                        'value' => $model->jobType->job_type_name,
                                    ),
//		'finance_job_type_id',
		'rate',
	),
)); ?>
