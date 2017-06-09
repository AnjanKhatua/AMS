<?php
/* @var $this StaffHolidayController */
/* @var $model StaffHoliday */

$this->breadcrumbs=array(
	'Staff Holidays'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Staff Holiday', 'url'=>array('index')),
	array('label'=>'Create Staff Holiday', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#staff-holiday-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Staff Holidays</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'staff-holiday-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'holiday_id',
		array("name"=>"start_date","value"=>'Utility::changeDateToUK($data->start_date)'),
                                        array("name"=>"end_date","value"=>'Utility::changeDateToUK($data->end_date)'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
