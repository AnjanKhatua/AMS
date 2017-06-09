<?php
/* @var $this HospitalJobTypeRateController */
/* @var $model HospitalJobTypeRate */

$this->breadcrumbs=array(
	'Hospital Job Type Rates'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Hospital Job Type Rate', 'url'=>array('index')),
	array('label'=>'Manage Hospital Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>Create Hospital Job Type Rate</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>