<?php
/* @var $this HospitalJobTypeRateController */
/* @var $model HospitalJobTypeRate */

$this->breadcrumbs=array(
	'Hospital Job Type Rates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Hospital Job Type Rate', 'url'=>array('index')),
	array('label'=>'Create Hospital Job Type Rate', 'url'=>array('create')),
	array('label'=>'View Hospital Job Type Rate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Hospital Job Type Rate', 'url'=>array('admin')),
);
?>

<h1>Update Hospital Job Type Rate <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>