<?php
/* @var $this TimesheetPaymentDetailsForStaffController */
/* @var $model TimesheetPaymentDetailsForStaff */

$this->breadcrumbs = array(
    'Timesheet Payment Details For Staff' => array('index'),
    'Manage',
);

$this->menu = array(
//    array('label' => 'List Timesheet Payment Details For Staff', 'url' => array('index')),
    array('label' => 'Create Timesheet Payment Details For Staff', 'url' => array('create')),
    array('label' => 'Manage Timesheet Payment Details For Staff', 'url' => array('admin')),
);
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even){background-color: #c4c4c4}
    tr th{background-color: #00ff00}
</style>

<h1>Download Time-sheet for each week</h1>

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
//$lo_units = HospitalUnit::model()->findAll("hospital_unit_active_status='Y'");
//$la_units = CHtml::listData(HospitalUnit::model()->findAll("hospital_unit_active_status='Y'"), 'hospital_unit_id', 'hospital_unit');

$allDate = Utility::getWeekDate();
$la_forTimesheetList = array("" => "Select Week End Date");
foreach ($allDate as $k => $lo_value) {
    $key = $k;
    $value = $lo_value;
    $la_forTimesheetList[$key] = $value;
}

?>

<h3>View timesheet list for <?php echo CHtml::dropDownList('week_end_date', $_REQUEST['id'], $la_forTimesheetList, array('id' => 'downloadTimesheet')); ?></h3>
<?php
if ((isset($_SESSION['errorMsg'])) && ($_SESSION['errorMsg'] != "")) {
    ?>
    <span id="forgotPassWordError"><?php echo $_SESSION['errorMsg']; ?></span>
    <?php
    $_SESSION['errorMsg'] = "";
}
?>


<div id="mainDiv"></div>
<br>

