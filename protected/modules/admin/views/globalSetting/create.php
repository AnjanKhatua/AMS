<?php
/* @var $this GlobalSettingController */
/* @var $model GlobalSetting */

$this->breadcrumbs=array(
	'Global Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GlobalSetting', 'url'=>array('index')),
	array('label'=>'Manage GlobalSetting', 'url'=>array('admin')),
);
?>

<h1>Create GlobalSetting</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>