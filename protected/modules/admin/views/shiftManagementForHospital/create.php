<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */

$this->breadcrumbs = array(
    'Shift For Hospitals' => array('index'),
    'Create',
);

$this->menu = array(
    //array('label'=>'List ShiftManagementForHospital', 'url'=>array('index')),
    array('label' => 'Manage Shift For Hospital', 'url' => array('admin')),
    array('label' => 'Shift Created By You', 'url' => array('adminSelf')),
    array('label' => 'Manage Unfilled Shift', 'url' => array('adminUnfilled')),
);
?>

<h1>Create Shift For Hospital</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>