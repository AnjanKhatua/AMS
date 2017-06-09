<?php
/* @var $this WardHospitalUnitMapController */
/* @var $model WardHospitalUnitMap */

$this->breadcrumbs=array(
	'Ward Hospital Unit Maps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WardHospitalUnitMap', 'url'=>array('index')),
	array('label'=>'Manage WardHospitalUnitMap', 'url'=>array('admin')),
);
?>

<h1>Create WardHospitalUnitMap</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>