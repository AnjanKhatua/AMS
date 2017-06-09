<?php
/* @var $this HospitalJobTypeRateController */
/* @var $model HospitalJobTypeRate */

$this->breadcrumbs=array(
	'Hospital Job Type Rates'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Hospital Job Type Rate', 'url'=>array('index')),
	array('label'=>'Create Hospital Job Type Rate', 'url'=>array('create')),
	array('label'=>'Update Hospital Job Type Rate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Hospital Job Type Rate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Hospital Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>View Hospital Job Type Rate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
//		'hospital_unit_id',
		array(
                                        'name' => 'hospital_unit',
                                        'value' => $model->hospitalUnit->hospital_unit,
                                    ),
//		'finance_job_type_id',
                                    array(
                                        'name' => 'job_type_name',
                                        'value' => $model->jobType->job_type_name,
                                    ),
		'rate',
                                    'pay_rate_for_staffs',
	),
)); ?>
