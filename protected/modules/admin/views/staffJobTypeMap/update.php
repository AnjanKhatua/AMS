<?php
/* @var $this StaffJobTypeMapController */
/* @var $model StaffJobTypeMap */

$this->breadcrumbs=array(
	'Staff Job Type Maps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StaffJobTypeMap', 'url'=>array('index')),
	array('label'=>'Create StaffJobTypeMap', 'url'=>array('create')),
	array('label'=>'View StaffJobTypeMap', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StaffJobTypeMap', 'url'=>array('admin')),
);
?>

<h1>Update StaffJobTypeMap <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>