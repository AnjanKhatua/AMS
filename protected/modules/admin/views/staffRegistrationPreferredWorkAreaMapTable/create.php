<?php
/* @var $this StaffRegistrationPreferredWorkAreaMapTableController */
/* @var $model StaffRegistrationPreferredWorkAreaMapTable */

$this->breadcrumbs=array(
	'Staff Registration Preferred Work Area Map Tables'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('index')),
	array('label'=>'Manage StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('admin')),
);
?>

<h1>Create StaffRegistrationPreferredWorkAreaMapTable</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>