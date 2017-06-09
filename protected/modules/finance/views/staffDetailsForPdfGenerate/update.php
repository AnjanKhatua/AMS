<?php
/* @var $this StaffDetailsForPdfGenerateController */
/* @var $model StaffDetailsForPdfGenerate */

$this->breadcrumbs=array(
	'Staff Details For Pdf Generates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StaffDetailsForPdfGenerate', 'url'=>array('index')),
	array('label'=>'Create StaffDetailsForPdfGenerate', 'url'=>array('create')),
	array('label'=>'View StaffDetailsForPdfGenerate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StaffDetailsForPdfGenerate', 'url'=>array('admin')),
);
?>

<h1>Update StaffDetailsForPdfGenerate <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>