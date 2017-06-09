<?php
/* @var $this StaffDetailsForPdfGenerateController */
/* @var $model StaffDetailsForPdfGenerate */

$this->breadcrumbs=array(
	'Staff Details For Pdf Generates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StaffDetailsForPdfGenerate', 'url'=>array('index')),
	array('label'=>'Manage StaffDetailsForPdfGenerate', 'url'=>array('admin')),
);
?>

<h1>Create StaffDetailsForPdfGenerate</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>