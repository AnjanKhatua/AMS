<?php
/* @var $this TrainingDetailsController */
/* @var $model TrainingDetails */

$this->breadcrumbs=array(
	'Training Details'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Training Details', 'url'=>array('index')),
	array('label'=>'Create Training Details', 'url'=>array('create')),
	array('label'=>'Update Training Details', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Training Details', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Training Details', 'url'=>array('admin')),
);
?>

<h1>View Training Details #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
//		'training_id',
                                    array(
                                        'name' => 'course_name',
                                        'value' => $model->allTrainings->course_name,
                                    ),
                                    array(
                                        'name' => 'email',
                                        'value' => $model->staff->email,
                                    ),
//		'staff_id',
		'fees_paid_date',
		'fees',
		'deduction_amount',
		'remaining_amount',
	),
)); ?>
