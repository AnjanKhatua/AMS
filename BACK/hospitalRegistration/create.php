<?php

/* @var $this HospitalRegistrationController */

/* @var $model HospitalRegistration */



$this->breadcrumbs=array(

	'Hospital Registrations'=>array('index'),

	'Create',

);



$this->menu=array(

	//array('label'=>'Hospital List', 'url'=>array('index')),

	array('label'=>'Manage Hospital', 'url'=>array('admin')),

);

?>



<h1>Create HospitalRegistration</h1>



<?php $this->renderPartial('_form', array('model'=>$model, 'modelunit' =>$modelunit)); ?>