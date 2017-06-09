<?php
/* @var $this DocumentHeaderController */
/* @var $model DocumentHeader */

$this->breadcrumbs=array(
	'Document Headers'=>array('index'),
	$model->document_header_id=>array('view','id'=>$model->document_header_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Document Header', 'url'=>array('index')),
	array('label'=>'Create Document Header', 'url'=>array('create')),
	array('label'=>'View Document Header', 'url'=>array('view', 'id'=>$model->document_header_id)),
	array('label'=>'Manage Document Header', 'url'=>array('admin')),
);
?>

<h1>Update Document Header <?php echo $model->document_header_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>