<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */

$this->breadcrumbs=array(
	'Hospital Registrations'=>array('index'),
	$model->hospital_id=>array('view','id'=>$model->hospital_id),
	'Update',
);

$this->menu=array(
	//array('label'=>'Hospital List', 'url'=>array('index')),
	array('label'=>'Create Hospital', 'url'=>array('create')),
	array('label'=>'View Hospital', 'url'=>array('view', 'id'=>$model->hospital_id)),
	array('label'=>'Manage Hospital', 'url'=>array('admin')),
);
?>

<h1>Update HospitalRegistration <?php echo $model->hospital_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'modelunit' =>$modelunit)); ?>