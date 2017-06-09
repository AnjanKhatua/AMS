<?php
/* @var $this StaffRegistrationPreferredWorkAreaMapTableController */
/* @var $model StaffRegistrationPreferredWorkAreaMapTable */

$this->breadcrumbs=array(
	'Staff Registration Preferred Work Area Map Tables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('index')),
	array('label'=>'Create StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('create')),
	array('label'=>'View StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('admin')),
);
?>

<h1>Update StaffRegistrationPreferredWorkAreaMapTable <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>