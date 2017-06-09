<?php
/* @var $this StaffRegistrationPreferredWorkAreaMapTableController */
/* @var $model StaffRegistrationPreferredWorkAreaMapTable */

$this->breadcrumbs=array(
	'Staff Registration Preferred Work Area Map Tables'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('index')),
	array('label'=>'Create StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('create')),
	array('label'=>'Update StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StaffRegistrationPreferredWorkAreaMapTable', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StaffRegistrationPreferredWorkAreaMapTable', 'url'=>array('admin')),
);
?>

<h1>View StaffRegistrationPreferredWorkAreaMapTable #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'staff_id',
		'work_area_id',
	),
)); ?>
