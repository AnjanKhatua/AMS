<?php
/* @var $this WardHospitalUnitMapController */
/* @var $model WardHospitalUnitMap */

$this->breadcrumbs=array(
	'Ward Hospital Unit Maps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WardHospitalUnitMap', 'url'=>array('index')),
	array('label'=>'Create WardHospitalUnitMap', 'url'=>array('create')),
	array('label'=>'View WardHospitalUnitMap', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WardHospitalUnitMap', 'url'=>array('admin')),
);
?>

<h1>Update WardHospitalUnitMap <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>