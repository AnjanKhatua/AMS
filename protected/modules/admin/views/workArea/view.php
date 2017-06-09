<?php
/* @var $this WorkAreaController */
/* @var $model WorkArea */

$this->breadcrumbs=array(
	'Work Areas'=>array('index'),
	$model->work_area_id,
);

$this->menu=array(
	array('label'=>'List WorkArea', 'url'=>array('index')),
	array('label'=>'Create WorkArea', 'url'=>array('create')),
	array('label'=>'Update WorkArea', 'url'=>array('update', 'id'=>$model->work_area_id)),
	array('label'=>'Delete WorkArea', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->work_area_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WorkArea', 'url'=>array('admin')),
);
?>

<h1>View Work Area #<?php echo $model->work_area_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'work_area_id',
		'area_name',
		'area_active_status',
	),
)); ?>
