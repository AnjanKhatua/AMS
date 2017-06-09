<?php
/* @var $this StaffDocumentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Documents',
);

$this->menu=array(
	array('label'=>'Create StaffDocument', 'url'=>array('create')),
	array('label'=>'Manage StaffDocument', 'url'=>array('admin')),
);
?>

<h1>Staff Documents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
