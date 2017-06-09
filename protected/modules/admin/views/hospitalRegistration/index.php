<?php
/* @var $this HospitalRegistrationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Hospital Group',
);

$this->menu=array(
	array('label'=>'Create HospitalRegistration', 'url'=>array('create')),
	array('label'=>'Manage HospitalRegistration', 'url'=>array('admin')),
);
?>

<h1>Hospital Registrations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
