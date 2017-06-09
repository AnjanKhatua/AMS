<?php
/* @var $this StaffDetailsForPdfGenerateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff Details For Pdf Generates',
);

$this->menu=array(
	array('label'=>'Create StaffDetailsForPdfGenerate', 'url'=>array('create')),
	array('label'=>'Manage StaffDetailsForPdfGenerate', 'url'=>array('admin')),
);
?>

<h1>Staff Details For Pdf Generates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
