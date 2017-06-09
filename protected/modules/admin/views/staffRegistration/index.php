<?php
/* @var $this StaffRegistrationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Registrations',
);

$this->menu=array(
	array('label'=>'Create Staff Registration', 'url'=>array('create')),
	array('label'=>'Manage Staff Registration', 'url'=>array('admin')),
);
?>

<h1>Staff Registrations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
