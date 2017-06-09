<?php

/* @var $this HospitalRegistrationController */

/* @var $model HospitalRegistration */



$this->breadcrumbs=array(

	'Hospital Registrations'=>array('index'),

	'Manage',

);



$this->menu=array(

	//array('label'=>'Hospital List', 'url'=>array('index')),

	array('label'=>'Create Hospital', 'url'=>array('create')),

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



<h1>Manage Hospital Registrations</h1>



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

		'hospital_status',

		array(

			'class'=>'CButtonColumn',

		),

	),

)); ?>

