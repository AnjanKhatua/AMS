<?php
/* @var $this JobTypeForFinanceController */
/* @var $model JobTypeForFinance */

$this->breadcrumbs=array(
	'Job Type For Finances'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Job Type For Finance', 'url'=>array('index')),
	array('label'=>'Create Job Type For Finance', 'url'=>array('create')),
	array('label'=>'View Job Type For Finance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Job Type For Finance', 'url'=>array('admin')),
);
?>

<h1>Update Job Type For Finance <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>