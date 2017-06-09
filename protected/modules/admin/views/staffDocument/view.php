<?php
/* @var $this StaffDocumentController */
/* @var $model StaffDocument */

$this->breadcrumbs=array(
	'Staff Documents'=>array('index'),
	$model->document_id,
);

$this->menu=array(
	array('label'=>'List StaffDocument', 'url'=>array('index')),
	array('label'=>'Create StaffDocument', 'url'=>array('create')),
	array('label'=>'Update StaffDocument', 'url'=>array('update', 'id'=>$model->document_id)),
	array('label'=>'Delete StaffDocument', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->document_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StaffDocument', 'url'=>array('admin')),
);
?>

<h1>View StaffDocument #<?php echo $model->document_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'document_id',
		'staff_id',
		'document_header_id',
		'document_name',
	),
)); ?>
