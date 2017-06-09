<?php
/* @var $this ShiftEnquiryAckController */
/* @var $model ShiftEnquiryAck */

$this->breadcrumbs=array(
	'Shift Enquiry Acks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ShiftEnquiryAck', 'url'=>array('index')),
	array('label'=>'Create ShiftEnquiryAck', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shift-enquiry-ack-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Shift Enquiry Acks</h1>

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
	'id'=>'shift-enquiry-ack-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'enquiry_id',
		'staff_request_id',
		'staff_id',
		'enquired_by',
		'availability_confirmed_by_staff',
		'availability_confirmed_via',
		/*
		'confirmed_by',
		'agent_user_id',
		'is_confirmed',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
