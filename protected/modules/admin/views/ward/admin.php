<?php
/* @var $this WardController */
/* @var $model Ward */

$this->breadcrumbs=array(
	'Wards'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Ward', 'url'=>array('index')),
	array('label'=>'Create Ward', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ward-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Wards</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ward-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'ward_id',
		'ward_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
