<?php
/* @var $this StaffDocumentController */
/* @var $model StaffDocument */

$this->breadcrumbs=array(
	'Staff Documents'=>array('index'),
	$model->document_id=>array('view','id'=>$model->document_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StaffDocument', 'url'=>array('index')),
	array('label'=>'Create StaffDocument', 'url'=>array('create')),
	array('label'=>'View StaffDocument', 'url'=>array('view', 'id'=>$model->document_id)),
	array('label'=>'Manage StaffDocument', 'url'=>array('admin')),
);
?>

<h1>Update StaffDocument <?php echo $model->document_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>