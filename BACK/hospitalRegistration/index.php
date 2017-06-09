<?php
/* @var $this HospitalRegistrationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Hospital Registrations',
);

$this->menu=array(
	array('label'=>'Create Hospital', 'url'=>array('create')),
	array('label'=>'Manage Hospital', 'url'=>array('admin')),
);
?>

<h1>Hospital Registrations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
