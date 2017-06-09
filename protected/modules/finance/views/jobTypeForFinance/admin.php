<?php
/* @var $this JobTypeForFinanceController */
/* @var $model JobTypeForFinance */

$this->breadcrumbs = array(
    'Job Type For Finances' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List Job Type For Finance', 'url'=>array('index')),
    array('label' => 'Create Job Type For Finance', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#job-type-for-finance-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Job Type For Finances</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'job-type-for-finance-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
//		'job_type_id',
        array(
            'name' => 'job_type',
            'value' => '$data->jobType->job_type',
        ),
        'job_type_name',
//		'status',
        array(
            'name' => 'status',
            'value' => '$data["status"]==\'Y\' ? \'Yes\' : \'No\'',
            'type' => 'text'
        ),
//        array(
//            'class' => 'CButtonColumn',
//        ),
        array(
            'header' => 'Action',
            'class' => 'CButtonColumn',
            'template' => '{update}{view}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => 'true',
                ),
                'view' => array(
                    'visible' => 'true',
                ),
                'delete' => array(
                    'visible' => 'false',
                ),
            ),
        ),
    ),
));
?>
