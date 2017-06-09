<?php
/* @var $this HospitalUnitController */
/* @var $model HospitalUnit */

$this->breadcrumbs = array(
    'Hospitals' => array('index'),
        //$model->hospital_unit_id,
);

$this->menu = array(
    //array('label'=>'List HospitalUnit', 'url'=>array('index')),
    array('label' => 'Create Hospital', 'url' => array('create'),'visible'=>Utility::checkLoginPerson($_SESSION[logged_user][type])),
    array('label' => 'Update Hospital', 'url' => array('update', 'id' => $model->hospital_unit_id),'visible'=>Utility::checkLoginPerson($_SESSION[logged_user][type])),
    array('label' => 'Delete Hospital', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->hospital_unit_id), 'confirm' => 'Are you sure you want to delete this item?'),'visible'=>Utility::checkLoginPerson($_SESSION[logged_user][type])),
    array('label' => 'Manage Hospital', 'url' => array('admin')),
);
?>

<h1>View Hospital</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        //'hospital_unit_id',
        array(
            'name' => 'hospital_id',
            'value' => $model->hospital->hospital_name,
        ),
        'hospital_unit',
        array(
            'name' => 'wards',
            'value' => $wards,
        ),
        'address',
        array(
            'name' => 'area_name',
            'value' => $model->localArea->area_name,
        ),
        array(
            'label' => 'Hospital Email',
            'value' => $model->hospital_email,
        ),
        array(
            'name' => 'relevant_coordinator',
            'value' => $model->hospitals->email,
        ),
        'contact_number',
        'training_needed',
//        array(
//            'label' => 'Training Needed',
//            'value' => $model->allTraining->course_name,
//        ),
        array(
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
        ),
    ),
));
?>
