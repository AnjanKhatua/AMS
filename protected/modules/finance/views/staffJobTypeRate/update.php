<?php
/* @var $this StaffJobTypeRateController */
/* @var $model StaffJobTypeRate */

$this->breadcrumbs=array(
	'Staff Job Type Rates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Staff Job Type Rate', 'url'=>array('index')),
	array('label'=>'Create Staff Job Type Rate', 'url'=>array('create')),
	array('label'=>'View Staff Job Type Rate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Staff Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>Update Staff Job Type Rate <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>