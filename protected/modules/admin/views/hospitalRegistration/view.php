<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */

$this->breadcrumbs=array(
	'Hospital Group'=>array('index'),
	//$model->hospital_id,
);

$this->menu=array(
	//array('label'=>'List Hospital Group', 'url'=>array('index')),
	array('label'=>'Create Hospital Group', 'url'=>array('create')),
	array('label'=>'Update Hospital Group', 'url'=>array('update', 'id'=>$model->hospital_id)),
	//array('label'=>'Delete HospitalRegistration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->hospital_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Hospital Group', 'url'=>array('admin')),
);
?>

<h1>View Hospital Group</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'hospital_id',
		'hospital_name',
		array(
			'name'=>'hospital_status',
			'value'=>function($data){
				if($data->hospital_status == 'A'){
					$status = "Active";
				} else if($data->hospital_status == 'I'){
					$status = "Inactive"; 
				} else if($data->hospital_status == 'S'){
					$status = "Suspended";
				}
				return $status;
			},
			'type'=>'text',
		),
	),
)); ?>
