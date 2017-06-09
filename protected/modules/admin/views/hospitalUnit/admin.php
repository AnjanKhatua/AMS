<?php
/* @var $this HospitalUnitController */
/* @var $model HospitalUnit */

$this->breadcrumbs = array(
    'Hospitals' => array('index'),
    'Manage',
);

$this->menu = array(
    //array('label'=>'List HospitalUnit', 'url'=>array('index')),
    array('label' => 'Create Hospital', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#hospital-unit-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Hospitals</h1>

<!--<li><p>Shift details for a day :--> 
        <?php
        echo CHtml::button('Calendar View', array(
            'submit' => array('hospitalUnit/eventCalendar&id=0')
        ));
        ?> 
    <!--</p></li>-->

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
    'id' => 'hospital-unit-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        //'hospital_unit_id',
        //'hospital_id',
        'hospital_unit',
        array(
            'name' => 'hospital_id',
            'value' => '$data->hospital->hospital_name',
        ),
        'address',
        array(
            'name' => 'area_name',
            'value' => '$data->localArea->area_name',
        ),
//        'email',
        array(
            'name' => 'email',
            'value' => '$data->hospitals->email',
        ),
        'contact_number',
        'training_needed',
//        array(
//            'name' => 'course_name',
//            'value' => '$data->allTraining->course_name',
//        ),
//        'hospital_unit_active_status',
        /* array(
          'name' => 'hospital_unit_active_status',
          'value' => function($data) {
          if ($data->hospital_unit_active_status == 'Y') {
          $status = "Active";
          } else if ($data->hospital_unit_active_status == 'N') {
          $status = "Inactive";
          }
          return $status;
          },
          'type' => 'text',
          ), */
        array(
            'header' => 'Action',
            'class' => 'CButtonColumn',
            'template' => '{update}{view}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => 'Utility::checkLoginPerson($_SESSION[logged_user][type])',
                ),
                'view' => array(
                    'visible' => 'true',
                ),
                'delete' => array(
                    'visible' => 'Utility::checkLoginPerson($_SESSION[logged_user][type])',
                ),
            ),
        ),
        array
            (
            'header' => 'Go To',
            'class' => 'CButtonColumn',
            'template' => '{quote}',
            'buttons' => array
                (
                'quote' => array
                    (
                    'label' => 'Event Cal',
                    'url' => 'Yii::app()->createUrl("admin/hospitalUnit/eventCalendar", array("id"=>$data->hospital_unit_id))',
                ),
            ),
        ),
    ),
));
?>
