<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
    $this->module->id,
);
?>
<?php
$outputArray = array();
if (isset($_POST['staffEmail']) && ($_POST['staffEmail'] != "")) {

    $ld_today = date("Y-m-d");
    $ld_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 30 day"));

    $userEmail = $_POST['staffEmail'];
    $startValue = strrpos($userEmail, "(") + 1;

    $ls_email = substr($userEmail, $startValue, -1);

    $startDate = $ld_today;
    $endDate = $ld_dateThreshold;

    $sqlQuery = "SELECT u.first_name, u.last_name, u.email, h.hospital_unit, j.job_type, w.ward_name, s.shift_start_datetime, s.shift_end_datetime FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b, {{ward}} w WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND s.ward_id = w.ward_id AND b.staff_id = u.id AND b.cancel_by_whom = '0' AND u.email = '" . $ls_email . "' AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY s.shift_start_datetime";
    $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

    $i = 0;
    $j = 0;

    $ls_resultReturnEmpty = "";

    if (count($command) == 0) {
        $ls_resultReturnEmpty = $_POST['staffEmail'] . " has not been allocated any shift for next 30 days!";
    }
    foreach ($command as $value) {
        $lv_staffName = $command[$j]['first_name'] . " " . $command[$j]['last_name'];

        $outputArray[$i]['staff_name'] = $lv_staffName;
        $outputArray[$i]['email'] = $command[$j]['email'];
        $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
        $outputArray[$i]['job_type'] = $command[$j]['job_type'];
        $outputArray[$i]['ward_name'] = $command[$j]['ward_name'];
        $outputArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($command[$j]['shift_start_datetime']);
        $outputArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($command[$j]['shift_end_datetime']);

        $i++;
        $j++;
    }
}
?>
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/css/jquery.multiselect.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery.multiselect.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/css/jquery.timepicker.css" />
<div class="row-fluid">
    <div class="span3">
        <div class="sidebar-nav">
            <ul id="yw2">
                <li>
                    <span>OPERATIONS</span>
                    <ul>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('admin/StaffRegistration/admin'); ?>"><span id="cExpiry">Manage Staff Registration</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <br>
    </div>
    <div class="span9">
        <div class="sidebar-nav">
            <ul id="yw2">
                <li>
                    <span class="ll1"></span>
                    <div style="padding-bottom: 5px; width: 50%">
                        <!--<span style="text-align: center"><h5><u>Enter your details</u></h5></span>-->
                    </div>
                    <ul>
                        <li>
                            <div id="staffRotaDetails">
                                <!--<form id="u_contact8" action="<?php // echo Yii::app()->createUrl('admin/default/getStaffRotaDetails');      ?>" method="post" enctype="multipart/form-data">-->
                                <form id="u_contact8" action="#" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="lll1"></span>
                                        <br>
                                        <span class="lll1">Report for : </span>
                                        <span><b><u>Staff rota</u></b></span>
                                        <hr>
                                    </div>
                                    <div>
                                        <span class="ll1">Select staff : </span>
                                        <input type="text" id="selectStaffEmail" name="staffEmail" value="<?php echo isset($_POST['staffEmail'])? $_POST['staffEmail'] : '' ?>">
                                        <span id="msgStaffEmail" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>
                            <table border="1" width="100%">
                                <?php
                                if (count($outputArray) != 0) {
                                    ?>

                                    <tr>
                                        <th>Staff name</th>
                                        <th>Email</th>
                                        <th>Hospital Name</th>
                                        <th>Job Type</th>
                                        <th>Ward Name</th>
                                        <th>Shift start datetime</th>
                                        <th>Shift end datetime</th>
                                    </tr>
                                    <?php
                                    foreach ($outputArray as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $value['staff_name']; ?></td>
                                            <td><?php echo $value['email']; ?></td>
                                            <td><?php echo $value['hospital_unit']; ?></td>
                                            <td><?php echo $value['job_type']; ?></td>
                                            <td><?php echo $value['ward_name']; ?></td>
                                            <td><?php echo $value['shift_start_datetime']; ?></td>
                                            <td><?php echo $value['shift_end_datetime']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } elseif ($ls_resultReturnEmpty != "") {
                                    ?>
                                        <span class="resultReturnEmpty"><?php echo $ls_resultReturnEmpty; ?></span>
                                    <?php
                                }
                                ?>
                            </table>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <script>
        $(function ()
        {
            $("#selectStaffEmail").autocomplete({
                source: 'index.php?r=admin/default/autocompleteNameEmail'
            });
        })

    </script> 