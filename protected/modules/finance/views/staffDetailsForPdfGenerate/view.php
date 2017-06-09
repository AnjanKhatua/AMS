<?php
/* @var $this StaffDetailsForPdfGenerateController */
/* @var $model StaffDetailsForPdfGenerate */

$this->breadcrumbs=array(
	'Staff Details For Pdf Generates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StaffDetailsForPdfGenerate', 'url'=>array('index')),
	array('label'=>'Create StaffDetailsForPdfGenerate', 'url'=>array('create')),
	array('label'=>'Update StaffDetailsForPdfGenerate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StaffDetailsForPdfGenerate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StaffDetailsForPdfGenerate', 'url'=>array('admin')),
);
?>

<h1>View StaffDetailsForPdfGenerate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'reference_id',
		'staff_id',
		'invoice_date',
	),
)); ?>
