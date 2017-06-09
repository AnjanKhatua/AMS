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
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/css/jquery.multiselect.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery.multiselect.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/css/jquery.timepicker.css" />
<?php
/* @var $this ShiftManagementForHospitalController */
/* @var $model ShiftManagementForHospital */

$this->breadcrumbs = array(
    'Booking Management For Hospitals'
);

if (isset($_GET["hospital_unit_id"])) {
    $li_hospitalUnitId = $_GET["hospital_unit_id"];
} else {
    $li_hospitalUnitId = 0;
}

$this->menu = array(
    array('label' => 'View Event Calender',
        'url' => array('eventCalendar&id=' . $li_hospitalUnitId)
    ),
);
?>
<div>
    <div style="float: left">
        <li>
            Change date for shift details : <input id="startDate" type="text" name="startDate" placeholder="yy-mm-dd"  value="<?php echo isset($_GET['date']) ? $_GET['date'] : "" ?>">
        </li>
    </div>
    <?php
//$lo_units = HospitalUnit::model()->findAll("hospital_unit_active_status='Y'");
//$la_units = CHtml::listData(HospitalUnit::model()->findAll("hospital_unit_active_status='Y'"), 'hospital_unit_id', 'hospital_unit');
    
    $ls_sqlForHospital = "SELECT h.hospital_unit_id, h.hospital_unit FROM {{hospital_unit}} h WHERE h.hospital_unit_active_status='Y' ORDER BY h.hospital_unit";

    $ls_resultForHospital = Yii::app()->db->createCommand($ls_sqlForHospital)->queryAll();
    $la_units = array("0" => "All Hospital");
    foreach ($ls_resultForHospital as $la_value) {
        $key = $la_value['hospital_unit_id'];
        $value = $la_value['hospital_unit'];
        $la_units[$key] = $value;
    }
    ?>
    <div style="float: left; padding-left: 15px;">
        <li>View event calendar for : <?php echo CHtml::dropDownList('id', $_GET['hospital_unit_id'], $la_units); ?></li>
    </div>
</div>
<div class="clearfix"></div>
<div><h3>Shift details on <?php echo Utility::changeDateToUK($_GET['date']) ?></h3></div>
<?php
if (count($model) != 0) {
    ?>
    <input type='button' id='btn' value='Print shift details' onclick='printDiv()'>
    <hr>
    <table border="1" width="100%" id='printableArea'>
        <tr>
            <th class="textAlign">Hospital Unit</th>
            <th class="textAlign">Shift start datetime</th>
<!--            <th class="textAlign">Shift end datetime</th>
            <th class="textAlign">Quantity</th>
            <th class="textAlign">Quantity confirmed</th>-->
            <th class="textAlign">Booked staff</th>
        </tr>
        <?php
        foreach ($model as $ls_value) {
            if($ls_value['status'] == 'Ar'){
            ?>
        <tr style="background-color: red">
            <?php
            }else{
            ?>
        <tr>
            <?php
            }
            ?>
                <td class="textAlign"><?php echo $ls_value['hospital_unit']; ?></td>
                <td class="textAlign"><?php echo Utility::changeDateToUK($ls_value['shift_start_datetime']); ?></td>
                <!--<td class="textAlign"><?php // echo Utility::changeDateToUK($ls_value['shift_end_datetime']);   ?></td>-->
                <!--<td class="textAlign"><?php // echo $ls_value['quantity'];   ?></td>-->
                <!--<td class="textAlign"><?php // echo $ls_value['quantity_confirmed'];   ?></td>-->
                <td class="textAlign"><?php echo ($ls_value['status'] != 'Ar') ? $ls_value['booked_staff'] : "Cancelled" ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    ?>
    <span id="forgotPassWordError"><?php echo 'No shift for this day!!'; ?></span>
    <?php
}
?>

<script type='text/javascript'>
    $(function ()
    {
//        $("select#selectHospital").multiselect();
        $("#startDate").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
        $("#startDate").change(function () {
            var getDate = $(this).val();
            var curUrl = window.location.href;
            var res = curUrl.split("&");
            console.log(res);
            var newUrl = res[0] + "&" + res[1] + "&date=" + getDate;
            location.href = newUrl;
        })
        $("#id").change(function () {
            var getHospitalId = $(this).val();
            var curUrl = window.location.href;
            var res = curUrl.split("&");
            console.log(res);
            var newUrl = res[0] + "&hospital_unit_id=" + getHospitalId + "&" + res[2];
            location.href = newUrl;
        })
    })
</script>