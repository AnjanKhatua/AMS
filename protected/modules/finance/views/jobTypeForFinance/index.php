<?php
/* @var $this JobTypeForFinanceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Job Type For Finances',
);

$this->menu=array(
	array('label'=>'Create Job Type For Finance', 'url'=>array('create')),
	array('label'=>'Manage Job Type For Finance', 'url'=>array('admin')),
);
?>

<h1>Job Type For Finances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
