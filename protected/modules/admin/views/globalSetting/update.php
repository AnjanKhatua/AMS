<?php
/* @var $this GlobalSettingController */
/* @var $model GlobalSetting */

$this->breadcrumbs=array(
	'Global Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GlobalSetting', 'url'=>array('index')),
	array('label'=>'Create GlobalSetting', 'url'=>array('create')),
	array('label'=>'View GlobalSetting', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GlobalSetting', 'url'=>array('admin')),
);
?>

<h1>Update GlobalSetting <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>