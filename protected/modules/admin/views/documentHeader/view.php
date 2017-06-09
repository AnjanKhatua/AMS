<?php
/* @var $this DocumentHeaderController */
/* @var $model DocumentHeader */

$this->breadcrumbs=array(
	'Document Headers'=>array('index'),
	$model->document_header_id,
);

$this->menu=array(
//	array('label'=>'List Document Header', 'url'=>array('index')),
	array('label'=>'Create Document Header', 'url'=>array('create')),
	array('label'=>'Update Document Header', 'url'=>array('update', 'id'=>$model->document_header_id)),
	array('label'=>'Delete Document Header', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->document_header_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Document Header', 'url'=>array('admin')),
);
?>

<h1>View Document Header #<?php echo $model->document_header_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'document_header_id',
		'header_name',
		'active_status',
	),
)); ?>
