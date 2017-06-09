<?php
/* @var $this GlobalSettingController */
/* @var $model GlobalSetting */

$this->breadcrumbs=array(
	'Global Settings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GlobalSetting', 'url'=>array('index')),
	array('label'=>'Create GlobalSetting', 'url'=>array('create')),
	array('label'=>'Update GlobalSetting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GlobalSetting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GlobalSetting', 'url'=>array('admin')),
);
?>

<h1>View GlobalSetting #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'field_name',
		'field_value',
	),
)); ?>
