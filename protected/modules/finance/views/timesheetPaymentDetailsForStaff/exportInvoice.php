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

<h1>Export invoice For Staff</h1>

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
$selectedDate = "";
$ls_sqlForPaymentList = "SELECT td.invoice_date FROM {{timesheet_training_deduction_week}} td WHERE td.apply_status = 'Y' GROUP BY td.invoice_date";
$la_resultForPaymentList = Yii::app()->db->createCommand($ls_sqlForPaymentList)->queryAll();

$la_forPaymentList = array("" => "Select Invoice Date");
foreach ($la_resultForPaymentList as $lo_value) {
    $key = $lo_value['invoice_date'];
    $value = Utility::changeDateToUK($lo_value['invoice_date']);
    $la_forPaymentList[$key] = $value;
}
//$day = strtotime('last Monday', strtotime('2016-10-29'));
//echo $value = Utility::changeDateToUK(date("Y-m-d", $day));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'timesheet-payment-details-for-staff-forms',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>

<h3>Export invoice for 
    <select id="selectStaffForAvailability" name="invoice_date">
        <?php
        foreach ($la_forPaymentList as $k => $lv_uname) {
            ?>
            <option  value="<?php echo $k; ?>"><?php echo $lv_uname; ?></option>
            <?php
        }
        ?>
    </select>
</h3>
<?php
if ((isset($_SESSION['errorMsg'])) && ($_SESSION['errorMsg'] != "")) {
    ?>
    <span id="forgotPassWordError"><?php echo $_SESSION['errorMsg']; ?></span>
    <?php
    $_SESSION['errorMsg'] = "";
}
?>
<br>

<?php
echo CHtml::button('Export Staff Invoice', array(
    'submit' => array('TimesheetPaymentDetailsForStaff/ExportGenerateInvoice'),
    'confirm' => 'Are you sure to Export Invoice?'
));
?>

<?php
echo CHtml::button('Export Hospital Invoice', array(
    'submit' => array('TimesheetPaymentDetailsForStaff/ExportGenerateInvoiceForHospital'),
    'confirm' => 'Are you sure to Export Invoice?'
));
?>
<?php $this->endWidget(); ?>
