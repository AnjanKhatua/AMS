<?php
/* @var $this WardHospitalUnitMapController */
/* @var $model WardHospitalUnitMap */

$this->breadcrumbs=array(
	'Ward Hospital Unit Maps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WardHospitalUnitMap', 'url'=>array('index')),
	array('label'=>'Create WardHospitalUnitMap', 'url'=>array('create')),
	array('label'=>'Update WardHospitalUnitMap', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WardHospitalUnitMap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WardHospitalUnitMap', 'url'=>array('admin')),
);
?>

<h1>View WardHospitalUnitMap #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'hospital_unit_id',
		'ward_id',
	),
)); ?>
