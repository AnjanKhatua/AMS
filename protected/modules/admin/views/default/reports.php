<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
    $this->module->id,
);
?>
<?php
//echo '<pre>';
//print_r($_SESSION['logged_user']) ; 
//echo '</pre>';
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
                            <a><span id="cExpiry">Expiry report</span></a>
                            <a><span id="cShiftAllocation">Shift allocation</span></a>
                            <a><span id="cStaffAvailability">Staff availability</span></a>
                            <a><span id="cStaffCancelReport">Staff cancel report by staff-wise</span></a>
                            <hr>
                            <a><span id="cNotAllocatedStaffReport">Not allocated staff report</span></a>
                            <a><span id="cRotaReport">Rota report</span></a>
                            <a><span id="cServiceDetailsForAnyHospital">Service details for any hospital</span></a>
                            <a><span id="cStaffRotaReport">Staff rota report</span></a>
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

                            <div id="dbs">
                                <form id="u_contact" action="<?php echo Yii::app()->createUrl('admin/default/Expiry'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="ll1"></span>
                                        <span class="errorMsg">
                                            <?php
                                            if ($model['errorNumber'] == 'set') {
                                                echo 'Enter correct mobile number!!';
                                            }
                                            ?></span><br>
                                        <span class="ll1">Report for : </span>
                                        <span><b><u>Expiry</u></b></span>
                                        <hr>
                                    </div>
                                    <div>
                                        <span class="ll1">Report for : </span>
                                        <select name="expiry">
                                            <option value="DBS_expiry">DBS expiry</option>
                                            <option value="Visa_expiry">Visa expiry</option>
                                            <option value="Passport_expiry">Passport expiry</option>
                                            <option value="Mandatory_training_expiry">Mandatory training expiry</option>
                                            <option value="Pmva_expiry">PMVA expiry</option>
                                            <option value="Maybo_expiry">Maybo Training expiry</option>
                                            <option value="Pin_expiry">Pin expiry</option>
                                        </select>
                                        <span id="msgnewcontact"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateDbs" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['startDate']) ? $_POST['startDate'] : "" ?>">
                                        <span id="msgStartDate" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateDbs" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['endDate']) ? $_POST['endDate'] : "" ?>">
                                        <span id="msgEndDate" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                            <div id="visa">
                                <form id="u_contact1" action="<?php echo Yii::app()->createUrl('admin/default/VisaExpiry'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="ll1"></span>
                                        <br>
                                        <span class="ll1">Report for : </span>
                                        <span><b><u>Visa expiry</u></b></span>
                                        <hr>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateVisa" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgStartDateVisa" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateVisa" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgEndDateVisa" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                            <div id="shiftAllocation">
                                <form id="u_contact2" action="<?php echo Yii::app()->createUrl('admin/default/ShiftAllocation'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="ll1"></span>
                                        <br>
                                        <span class="ll1">Report for : </span>
                                        <span><b><u>Shift allocation</u></b></span>
                                        <hr>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateShiftAllocation" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgStartDateShiftAllocation" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateShiftAllocation" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgEndDateShiftAllocation" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List" />
                                    </div>
                                </form>
                            </div>

                            <div id="staffAvailability">
                                <form id="u_contact3" action="<?php echo Yii::app()->createUrl('admin/default/StaffAvailability'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="ll1"></span>
                                        <br>
                                        <span class="ll1">Report for : </span>
                                        <span><b><u>Staff availability</u></b></span>
                                        <hr>
                                    </div>
                                    <?php
                                    $allStaff = StaffRegistration::model()->staffAll();
                                    ?>  
                                    <div>
                                        <span class="ll1">Select Staff : </span>
                                        <select id="selectStaffForAvailability" name="staff">
                                            <option  value="">Select an option</option>
                                            <?php
                                            foreach ($allStaff as $k => $lv_uname) {
                                                ?>
                                                <option  value="<?php echo $k; ?>"><?php echo $lv_uname; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span id="msgStaffForAvailability" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <div style="float:left">
                                            <span class="ll1">Start date : </span>
                                            <input id="startDateStaffAvailability" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                            <span id="msgStartDateStaffAvailability" class="errorMessage" style="display:block; padding-left:103px;"></span>
                                            <span class="ll1">Start time : </span>
                                            <input id="startTimeStaffAvailability" type="text" name="startTime" placeholder="Enter start time"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                            <span id="msgStartTimeStaffAvailability" class="errorMessage" style="display:block"></span>
                                        </div>
                                    </div>

                                    <div>
                                        <div style="float:left">
                                            <span class="ll1">End date : </span>
                                            <input id="endDateStaffAvailability" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                            <span id="msgEndDateStaffAvailability" class="errorMessage" style="display:block;padding-left:103px;"></span>
                                            <span class="ll1">End time : </span>
                                            <input id="endTimeStaffAvailability" type="text" name="endTime" placeholder="Enter end time" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                            <span id="msgEndTimeStaffAvailability" class="errorMessage" style="display:block; padding-left:103px;"></span>
                                        </div>
                                    </div>
                                    <div class="span9">
                                        <span class="ll1"></span>
                                        <input  style="margin: 0 auto" type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                            <div id="staffCancelReport">
                                <form id="u_contact4" action="<?php echo Yii::app()->createUrl('admin/default/StaffCancelReport'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="lll1"></span>
                                        <br>
                                        <span class="lll1">Report for : </span>
                                        <span><b><u>Staff cancel report by staff-wise</u></b></span>
                                        <hr>
                                    </div>
                                    <?php
                                    $allStaff = StaffRegistration::model()->staffAll();
                                    ?>  
                                    <div>
                                        <span class="ll1">Select Staff : </span>
                                        <select id="selectStaffForReport" name="staff">
                                            <option  value="">Select an option</option>
                                            <?php
                                            foreach ($allStaff as $k => $lv_uname) {
                                                ?>
                                                <option  value="<?php echo $k; ?>"><?php echo $lv_uname; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span id="msgStaffForReport" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateStaffCancelReport" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgStartDateStaffCancelReport" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateStaffCancelReport" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgEndDateStaffCancelReport" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                            <div id="notAllocatedStaffReport">
                                <form id="u_contact5" action="<?php echo Yii::app()->createUrl('admin/default/NotAllocatedStaffReport'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="lll1"></span>
                                        <br>
                                        <span class="lll1">Report for : </span>
                                        <span><b><u>Not allocated staff report</u></b></span>
                                        <hr>
                                    </div>
                                    <?php
                                    $allStaff = StaffRegistration::model()->staffAll();
                                    ?>  
                                    <div>
                                        <span class="ll1">Select Staff : </span>
                                        <select id="selectStaff" name="staff">
                                            <option  value="">Select an option</option>
                                            <?php
                                            foreach ($allStaff as $k => $lv_uname) {
                                                ?>
                                                <option  value="<?php echo $k; ?>"><?php echo $lv_uname; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span id="msgStaffForNonAlloc" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateNotAllocatedStaffReport" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgStartDateNotAllocatedStaffReport" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateNotAllocatedStaffReport" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgEndDateNotAllocatedStaffReport" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                            <div id="rotaReport">
                                <form id="u_contact6" action="<?php echo Yii::app()->createUrl('admin/default/RotaReport'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="lll1"></span>
                                        <br>
                                        <span class="lll1">Report for : </span>
                                        <span><b><u>Rota report</u></b></span>
                                        <hr>
                                    </div>
                                    <?php
                                    $allStaff = HospitalUnit::model()->allHospital();
                                    ?>  
                                    <div>
                                        <span class="ll1">Select Hospital : </span>
                                        <select id="selectHospital" name="hospital[]" multiple="multiple">
                                            <?php
                                            foreach ($allStaff as $k => $lv_uname) {
                                                ?>
                                                <option  value="<?php echo $k; ?>"><?php echo $lv_uname; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span id="msgHospitalForRota" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateRotaReport" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgStartDateRotaReport" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateRotaReport" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgEndDateRotaReport" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                            <div id="serviceDetailsForAnyHospital">
                                <form id="u_contact7" action="<?php echo Yii::app()->createUrl('admin/default/ServiceDetailsForAnyHospital'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="lll1"></span>
                                        <br>
                                        <span class="lll1">Report for : </span>
                                        <span><b><u>Service details for any hospital</u></b></span>
                                        <hr>
                                    </div>
                                    <?php $la_allHospitalUnits = CHtml::listData(HospitalUnit::model()->findAll('hospital_unit_active_status="Y"'), 'hospital_unit_id', 'hospital_unit'); ?>        
                                    <div>
                                        <span class="ll1">Select hospital : </span>
                                        <select id="selectHospitalForService" name="hospital">
                                            <option  value="">Select an option</option>
                                            <?php
                                            foreach ($la_allHospitalUnits as $k => $lv_uname) {
                                                ?>
                                                <option  value="<?php echo $k; ?>"><?php echo $lv_uname; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span id="msgHospitalForService" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateServiceDetailsForAnyHospital" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgStartDateServiceDetailsForAnyHospital" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateServiceDetailsForAnyHospital" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgEndDateServiceDetailsForAnyHospital" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                            <div id="staffRota">
                                <form id="u_contact8" action="<?php echo Yii::app()->createUrl('admin/default/StaffRota'); ?>" method="post" enctype="multipart/form-data">
                                    <div>
                                        <span class="lll1"></span>
                                        <br>
                                        <span class="lll1">Report for : </span>
                                        <span><b><u>Staff rota</u></b></span>
                                        <hr>
                                    </div>
                                    <div>
                                        <span class="ll1">Select staff : </span>
                                        <input type="text" id="selectStaffEmail" name="staffEmail">
                                        <span id="msgStaffEmail" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">Start date : </span>
                                        <input id="startDateForStaffRota" type="text" name="startDate" placeholder="dd-mm-yy"  value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgStartDateServiceDetailsForAnyStaff" class="errorMessage"></span>
                                    </div>
                                    <div>
                                        <span class="ll1">End date : </span>
                                        <input id="endDateForStaffRota" type="text" name="endDate" placeholder="dd-mm-yy" value="<?php echo isset($_POST['newContact']) ? $_POST['newContact'] : "" ?>">
                                        <span id="msgEndDateServiceDetailsForAnyStaff" class="errorMessage"></span>
                                    </div>
                                    <div class="l2">
                                        <input type="submit" value="Check List"/>
                                    </div>
                                </form>
                            </div>

                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <script>
        $(function ()
        {
            $("select#selectHospital").multiselect();
            $("#startDateDbs").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateDbs").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });

            $("#startDateVisa").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateVisa").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });

            $("#startDateShiftAllocation").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateShiftAllocation").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });

            $("#startDateStaffAvailability").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateStaffAvailability").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#startTimeStaffAvailability").timepicker({
                'timeFormat': 'H:i:s'
            });
            $("#endTimeStaffAvailability").timepicker({
                'timeFormat': 'H:i:s'
            });

            $("#startDateStaffCancelReport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateStaffCancelReport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });

            $("#startDateNotAllocatedStaffReport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateNotAllocatedStaffReport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });

            $("#startDateRotaReport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateRotaReport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });

            $("#startDateServiceDetailsForAnyHospital").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateServiceDetailsForAnyHospital").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });

            $("#startDateForStaffRota").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#endDateForStaffRota").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#selectStaffEmail").autocomplete({
                source: 'index.php?r=admin/default/autocomplete'
            });
        })

    </script> 