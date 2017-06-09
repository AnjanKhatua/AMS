<?php
/* @var $this StaffRegistrationController */
/* @var $model StaffRegistration */

$this->breadcrumbs=array(
	'Staff Registrations'=>array('index'),
	$model->staff_id=>array('view','id'=>$model->staff_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List StaffRegistration', 'url'=>array('index')),
	array('label'=>'Create Staff Registration', 'url'=>array('create')),
	array('label'=>'View Staff Registration', 'url'=>array('view', 'id'=>$model->staff_id)),
	array('label'=>'Manage Staff Registration', 'url'=>array('admin')),
);
?>

<h1>Update Staff Registration <?php echo $model->staff_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'allFiles' => $allFiles,'docTypes' => $docTypes)); ?>

