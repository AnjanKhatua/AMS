<?php
/* @var $this GlobalSettingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Global Settings',
);

$this->menu=array(
	array('label'=>'Create GlobalSetting', 'url'=>array('create')),
	array('label'=>'Manage GlobalSetting', 'url'=>array('admin')),
);
?>

<h1>Global Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
