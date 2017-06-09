<?php
/* @var $this WorkAreaController */
/* @var $model WorkArea */

$this->breadcrumbs=array(
	'Work Areas'=>array('index'),
	$model->work_area_id=>array('view','id'=>$model->work_area_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WorkArea', 'url'=>array('index')),
	array('label'=>'Create WorkArea', 'url'=>array('create')),
	array('label'=>'View WorkArea', 'url'=>array('view', 'id'=>$model->work_area_id)),
	array('label'=>'Manage WorkArea', 'url'=>array('admin')),
);
?>

<h1>Update Work Area <?php echo $model->work_area_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>