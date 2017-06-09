<?php
/* @var $this HospitalRegistrationController */
/* @var $model HospitalRegistration */

$this->breadcrumbs=array(
	'Hospital Group'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List HospitalRegistration', 'url'=>array('index')),
	array('label'=>'Create Hospital Group', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#hospital-registration-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1>Manage Hospital Groups</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hospital-registration-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'hospital_id',
		'hospital_name',	
		array(
			'name'=>'hospital_status',
			'value'=>function($data, $row){
				if($data->hospital_status == 'A'){
					$status = "Active";
				} else if($data->hospital_status == 'I'){
					$status = "Inactive"; 
				} else if($data->hospital_status == 'S'){
					$status = "Suspended";
				}
				return $status;
			},
			'type'=>'text',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
