<?php
/* @var $this StaffJobTypeRateController */
/* @var $model StaffJobTypeRate */

$this->breadcrumbs=array(
	'Staff Job Type Rates'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Staff Job Type Rate', 'url'=>array('index')),
	array('label'=>'Manage Staff Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>Create Staff Job Type Rate</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>