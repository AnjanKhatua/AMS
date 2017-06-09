<?php
/* @var $this UserActivityController */
/* @var $model UserActivity */

$this->breadcrumbs=array(
	'User Activities'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserActivity', 'url'=>array('index')),
	array('label'=>'Create UserActivity', 'url'=>array('create')),
	array('label'=>'View UserActivity', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserActivity', 'url'=>array('admin')),
);
?>

<h1>Update UserActivity <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>