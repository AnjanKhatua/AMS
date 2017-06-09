<?php
/* @var $this JobTypeForFinanceController */
/* @var $model JobTypeForFinance */

$this->breadcrumbs=array(
	'Job Type For Finances'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Job Type For Finance', 'url'=>array('index')),
	array('label'=>'Manage Job Type For Finance', 'url'=>array('admin')),
);
?>

<h1>Create Job Type For Finance</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>