<?php

/*
  Created on : 29th April, 2016
  It contains  frequently used functions
 */

class Utility {
    /*
     * @Function for validation
     * @Validation for Alpha With Space Fields
     */

    public static function formatInput($ls_inputString) {
        $ls_inputString = addslashes(trim($ls_inputString));
        return $ls_inputString;
    }

    public static function authenticateUser() {
        $sqlQuery = "SELECT * FROM {{user}} WHERE `email` = '" . $_SESSION['logged_user']['email'] . "' AND `password` = '" . $_SESSION['logged_user']['password'] . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if (count($command) == 0) {
            session_destroy();
            session_start();
            header('Location:' . Yii::app()->createUrl("site/login"));
            exit();
        }
    }

    public static function checkActionStatus($staff_id, $invoice_date, $week_end_date) {
        $sqlQuery = "SELECT * FROM {{timesheet_training_deduction_week}} WHERE `staff_id` = '" . $staff_id . "' AND `invoice_date` = '" . $invoice_date . "' AND `week_end_date` = '" . $week_end_date . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($command[0]['apply_status'] == 'N') {
            return 1;
        } else {
            return 0;
        }
    }

    public static function validateAlphaWithSpaceField($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter only letters!';
        if (!preg_match("/^[\*a-zA-Z\s]{2,75}$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Alpha With Space Field
     */

    public static function validateAlphaHyphenWithSpaceField($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter only letters, hyphen and space!';
        if (!preg_match("/^[\*a-zA-Z\s-]{2,75}$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Email Field
     */

    public static function validateEmailField($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter valid email!';
        if (!preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z]{2,4})+$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Contact Number
     */

    public static function validateMobileNumber($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter valid contact number, Starting with 44 and followed by next 10 digits!';
        if (!preg_match("/^([4][4][+0-9 ]{10})$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Contact Number
     */

    public static function validateTelephoneNumber($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter valid contact number, Starting with 44 and followed by next 10 digits!';
        if (!preg_match("/^([4][4][+0-9 ]{10,15})$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Alpha Numeric Field
     */

    public static function validateAlphaNumericField($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter only letters and numbers!';
        if (!preg_match("/^[a-zA-Z0-9]+$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Alpha Numeric with Space and Special Charecter Field
     */

    public static function validateAlphaNumericWithSpaceAndSpecialField($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter only letters, numbers and special charecter!';
        if (!preg_match("/^[a-zA-Z0-9\s:,.@()-_]+$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Alpha Numeric with Space Field
     */

    public static function validateAlphaNumericWithSpaceField($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter only letters and numbers!';
        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for validation
     * @Validation for Number
     */

    public static function validateNumberField($ls_fieldValue) {
//        $la_message = array();
        if ($ls_fieldValue == '')
            return 0;
        $ls_msg = 'Please enter only numbers!';
        if (!preg_match("/^\d+$/", $ls_fieldValue)) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for change date
     * @YYYY-MM-DD to DD-MM-YYYY
     */

    public static function changeDateToUK($ls_mysqlDate) {
        if ($ls_mysqlDate == "0000-00-00") /* This is done for showing blank during date format conversion for 0000-00-00 */ {
            return '';
        }
        if (strlen($ls_mysqlDate) == 10) /* For date field only */
            return date("d-m-Y", strtotime($ls_mysqlDate));
        else
            return date("d-m-Y H:i", strtotime($ls_mysqlDate));
    }

    /*
     * @Function for change date
     * @YYYY-MM-DD to DD-MM-YYYY
     */

    public static function changeDateToUKWithSlash($ls_mysqlDate) {
        if ($ls_mysqlDate == "0000-00-00") /* This is done for showing blank during date format conversion for 0000-00-00 */ {
            return '';
        }
        if (strlen($ls_mysqlDate) == 10) /* For date field only */
            return date("d/m/Y", strtotime($ls_mysqlDate));
        else
            return date("d/m/Y H:i", strtotime($ls_mysqlDate));
    }

    /*
     * @Function for change date
     * @YYYY-MM-DD to DD-MM-YYYY
     */

    public static function changeTimeFromDateToUK($ls_mysqlDate) {
        if ($ls_mysqlDate == "0000-00-00") /* This is done for showing blank during date format conversion for 0000-00-00 */ {
            return '';
        }
        if (strlen($ls_mysqlDate) == 10) /* For date field only */
            return date("d-m-Y", strtotime($ls_mysqlDate));
        else
            return date("H:i", strtotime($ls_mysqlDate));
    }

    /*
     * @Function for change date
     * @YYYY-MM-DD to DD-MM-YYYY
     */

    public static function changeTimeToUK($ls_mysqlDate) {
        if ($ls_mysqlDate == "00:00:00") /* This is done for showing blank during date format conversion for 0000-00-00 */ {
            return '';
        }
        if (strlen($ls_mysqlDate) == 8) /* For date field only */
            return date("H:i", strtotime($ls_mysqlDate));
    }

    /*
     * @Function for change date
     * @DD-MM-YYYY to YYYY-MM-DD
     */

    public static function changeDateToMysql($ls_ukDate) {
        if (strpos($ls_ukDate, '/')) /* if the separator is a slash (/), then the American m/d/y is assumed. */ {
            $ls_ukDate = str_replace('/', '-', $ls_ukDate);
        }
        if (strlen($ls_ukDate) == 10) /* For date field only */
            return date("Y-m-d", strtotime($ls_ukDate));
        else
            return date("Y-m-d H:i", strtotime($ls_ukDate));
    }

    /*
     * @Function for date difference
     */

    public static function dateDifference($ls_startDate, $ls_endDate) {
        if ($ls_startDate == '' || $ls_endDate == '')
            return 0;
        $ls_msg = 'Please enter end date properly. End date cannot be before start date!';
        $startDate = $ls_startDate;
        $endDate = $ls_endDate;
        $diff = strtotime($endDate) - strtotime($startDate);
        if ($diff < 0) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * @Function for time difference
     */

    public static function timeDifference($ls_startTime, $ls_endTime) {
        if ($ls_startTime == '' || $ls_endTime == '')
            return 0;
        $ls_msg = 'Please enter end time properly. End time cannot be less than start time!';
        $startDate = $ls_startTime;
        $endDate = $ls_endTime;
        $diff = strtotime($ls_endTime) - strtotime($ls_startTime);
        if ($diff < 0) {
            return $ls_msg;
        } else {
            return 0;
        }
    }

    /*
     * Function for get specific job type of specific staff
     * Used in : AvailableShiftForHospitalController.php and
     *                AvailableShiftForHospital.php
     */

    public function getAvailableJobTypeForStaff($li_staffId) {
        $sqlQuery = "SELECT `job_type_id`FROM {{staff_job_type_map}} WHERE `staff_id` = " . $li_staffId;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $array = array();
        $i = 0;
        foreach ($command as $lv_jobId) {
            $array[$i++] = $lv_jobId['job_type_id'];
        }
        return $array;
    }

    /*
     * Function for get archive shifts
     * Used in : ShiftManagementForHospital.php
     */

    public function getActiveShifts() {
        $ld_today = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT `staff_request_id` FROM {{shift_management_for_hospital}} WHERE `shift_start_datetime` >= '" . $ld_today . "' AND `status` = 'A'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $array = array();
        $i = 0;
        foreach ($command as $lv_staffRequestId) {
            $array[$i++] = $lv_staffRequestId['staff_request_id'];
        }
        return $array;
    }

    /*
     * Function for get unfilled shifts
     * Used in : ShiftManagementForHospital.php
     */

    public function getUnfilledShifts() {
        $ld_today = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT `staff_request_id`, `quantity`, `quantity_confirmed` FROM {{shift_management_for_hospital}} WHERE `shift_start_datetime` >= '" . $ld_today . "' AND `status` = 'A'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $array = array();
        $i = 0;
        foreach ($command as $lv_staffRequestId) {
            if ($lv_staffRequestId['quantity'] != $lv_staffRequestId['quantity_confirmed'])
                $array[$i++] = $lv_staffRequestId['staff_request_id'];
        }
        return $array;
    }

    /*
     * Function for get archive shifts
     * Used in : ShiftManagementForHospital.php
     */

    public function getArchiveShifts() {
        $ld_today = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `shift_start_datetime` < '" . $ld_today . "' OR `status` = 'Ar'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $array = array();
        $i = 0;
        foreach ($command as $lv_staffRequestId) {
            $array[$i++] = $lv_staffRequestId['staff_request_id'];
        }
        return $array;
    }

    /*
     * Function for get historical archive shifts
     * Used in : ShiftManagementForHospital.php
     */

    public function getHistoricalFilledShifts() {
        $ld_today = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `shift_start_datetime` < '" . $ld_today . "' AND `status` = 'A'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $array = array();
        $i = 0;
        foreach ($command as $lv_staffRequestId) {
            if ($lv_staffRequestId['quantity'] == $lv_staffRequestId['quantity_confirmed'])
                $array[$i++] = $lv_staffRequestId['staff_request_id'];
        }
        return $array;
    }

    /*
     * Function for get available date time of specific staff
     * Used in : AvailableShiftForHospitalController.php
     *                AvailableShiftForHospital.php
     */

    public function getAvailableDateTimeForStaff($li_staffId) {
        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `status` = 'A'  AND `shift_start_datetime` > '" . $date . "' AND `quantity` > `quantity_confirmed`";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $arrayId = array();
        $i = 0;
        $array = array();
        $j = 0;
        foreach ($command as $lv_staffRequestId) {
            $lv_shiftStartDate = substr($lv_staffRequestId['shift_start_datetime'], 0, 10);
            $lv_shiftStartTime = substr($lv_staffRequestId['shift_start_datetime'], 11);
            $lv_shiftEndDate = substr($lv_staffRequestId['shift_end_datetime'], 0, 10);
            $lv_shiftEndTime = substr($lv_staffRequestId['shift_end_datetime'], 11);
            $sqlQuery = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND '" . $lv_shiftStartTime . "'  BETWEEN r.start_time AND r.end_time";
            $sqlQuery1 = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND '" . $lv_shiftEndTime . "'  BETWEEN r.start_time AND r.end_time";
            $sqlQuery2 = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND '" . $lv_shiftStartTime . "' <= r.start_time AND r.start_time<='" . $lv_shiftEndTime . "'";
            $sqlQuery3 = "SELECT * FROM {{holiday}} WHERE '" . $lv_shiftStartDate . "' BETWEEN `start_date` AND `end_date` AND `staff_id` = " . $_SESSION['logged_user']['id'] . "
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE '" . $lv_shiftEndDate . "' BETWEEN `start_date` AND `end_date` AND `staff_id` = " . $_SESSION['logged_user']['id'] . "
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE `start_date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND `staff_id` = " . $_SESSION['logged_user']['id'];
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
            $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();
            $command3 = Yii::app()->db->createCommand($sqlQuery3)->queryAll();
            if (count($command) == 0 && count($command1) == 0 && count($command2) == 0 && count($command3) == 0) {
                $arrayId[$i++] = $lv_staffRequestId['staff_request_id'];
            }
        }
        $sqlQueryVisaValidation = "SELECT * FROM {{staff_registration}} s WHERE s.staff_id = '" . $_SESSION['logged_user']['staff_id'] . "' AND s.staff_status = 'A'  AND s.visa_expiry_date > '" . $lv_shiftEndDate . "'";
        $commandVisaValidation = Yii::app()->db->createCommand($sqlQueryVisaValidation)->queryAll();
        if (count($commandVisaValidation) != 0)
            foreach ($arrayId as $lv_id) {
                $sqlQuery = "SELECT * FROM {{booking}} WHERE `staff_id` = " . $li_staffId . " AND `staff_request_id` = " . $lv_id;
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                if (count($command) == 0) {
                    $array[$j++] = $lv_id;
                }
            }
        $sqlQueryForWorkArea = "SELECT sw.work_area_id FROM {{staff_registration}} s, {{user}} u, {{staff_registration_preferred_work_area_map_table}} sw WHERE sw.staff_id = s.staff_id AND s.staff_id = u.staff_id AND u.id = " . $li_staffId;
        $commandForWorkArea = Yii::app()->db->createCommand($sqlQueryForWorkArea)->queryAll();
        $la_workAreaForStaff = array();
        $l = 0;
        foreach ($commandForWorkArea AS $la_workArea) {
            $la_workAreaForStaff[$l++] = $la_workArea['work_area_id'];
        }
        $ids = implode(",", $la_workAreaForStaff);
        $arrayForShiftId = array();
        $j = 0;
        foreach ($array AS $la_id) {
            $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h WHERE s.hospital_unit_id = h.hospital_unit_id AND s.staff_request_id = '" . $la_id . "' AND h.local_area_id IN ($ids) ";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            if (count($command) != 0) {
                $arrayForShiftId[$j++] = $la_id;
            }
        }
        return $arrayForShiftId;
    }

    public function getAvailableDateTimeForStaffForApp($lo_staff_info) {
        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `status` = 'A'  AND `shift_start_datetime` > '" . $date . "' AND `quantity` > `quantity_confirmed`";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $arrayId = array();
        $i = 0;
        $array = array();
        $j = 0;
        foreach ($command as $lv_staffRequestId) {
            $lv_shiftStartDate = substr($lv_staffRequestId['shift_start_datetime'], 0, 10);
            $lv_shiftStartTime = substr($lv_staffRequestId['shift_start_datetime'], 11);
            $lv_shiftEndDate = substr($lv_staffRequestId['shift_end_datetime'], 0, 10);
            $lv_shiftEndTime = substr($lv_staffRequestId['shift_end_datetime'], 11);
            $sqlQuery = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $lo_staff_info->user_id . " AND `date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND '" . $lv_shiftStartTime . "'  BETWEEN r.start_time AND r.end_time";
            $sqlQuery1 = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $lo_staff_info->user_id . " AND `date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND '" . $lv_shiftEndTime . "'  BETWEEN r.start_time AND r.end_time";
            $sqlQuery2 = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $lo_staff_info->user_id . " AND `date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND '" . $lv_shiftStartTime . "' <= r.start_time AND r.start_time<='" . $lv_shiftEndTime . "'";
            $sqlQuery3 = "SELECT * FROM {{holiday}} WHERE '" . $lv_shiftStartDate . "' BETWEEN `start_date` AND `end_date` AND `staff_id` = " . $lo_staff_info->user_id . "
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE '" . $lv_shiftEndDate . "' BETWEEN `start_date` AND `end_date` AND `staff_id` = " . $lo_staff_info->user_id . "
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE `start_date` BETWEEN '" . $lv_shiftStartDate . "' AND '" . $lv_shiftEndDate . "' AND `staff_id` = " . $lo_staff_info->user_id;
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
            $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();
            $command3 = Yii::app()->db->createCommand($sqlQuery3)->queryAll();
            if (count($command) == 0 && count($command1) == 0 && count($command2) == 0 && count($command3) == 0) {
                $arrayId[$i++] = $lv_staffRequestId['staff_request_id'];
            }
        }
        $sqlQueryVisaValidation = "SELECT * FROM {{staff_registration}} s WHERE s.staff_id = '" . $lo_staff_info->staff_id . "' AND s.staff_status = 'A'  AND s.visa_expiry_date > '" . $lv_shiftEndDate . "'";
        $commandVisaValidation = Yii::app()->db->createCommand($sqlQueryVisaValidation)->queryAll();
        if (count($commandVisaValidation) != 0)
            foreach ($arrayId as $lv_id) {
                $sqlQuery = "SELECT * FROM {{booking}} WHERE `staff_id` = " . $lo_staff_info->user_id . " AND `staff_request_id` = " . $lv_id;
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                if (count($command) == 0) {
                    $array[$j++] = $lv_id;
                }
            }
        $sqlQueryForWorkArea = "SELECT sw.work_area_id FROM {{staff_registration}} s, {{user}} u, {{staff_registration_preferred_work_area_map_table}} sw WHERE sw.staff_id = s.staff_id AND s.staff_id = u.staff_id AND u.id = " . $lo_staff_info->user_id;
        $commandForWorkArea = Yii::app()->db->createCommand($sqlQueryForWorkArea)->queryAll();
        $la_workAreaForStaff = array();
        $l = 0;
        foreach ($commandForWorkArea AS $la_workArea) {
            $la_workAreaForStaff[$l++] = $la_workArea['work_area_id'];
        }
        $ids = implode(",", $la_workAreaForStaff);
        $arrayForShiftId = array();
        $j = 0;
        foreach ($array AS $la_id) {
            $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h WHERE s.hospital_unit_id = h.hospital_unit_id AND s.staff_request_id = '" . $la_id . "' AND h.local_area_id IN ($ids) ";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            if (count($command) != 0) {
                $arrayForShiftId[$j++] = $la_id;
            }
        }
        return $arrayForShiftId;
    }

    /*
     * Function for check the specific staff apply or not of a specific shift
     */

    public static function checkApplyStatus($li_shiftId, $li_staff_id) {
        $sqlQuery = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_id` = " . $li_staff_id . " AND `staff_request_id` = " . $li_shiftId;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if (count($command) == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * Function for check the specific shift expire or not
     */

    public static function checkShiftExpiryStatus($ls_shiftDate) {
        $ls_shiftDate = self::changeDateToMysql($ls_shiftDate);
        $ls_currentDate = date('Y-m-d H:i:s');
        $li_dateDifference = strtotime($ls_shiftDate) - strtotime($ls_currentDate);
        if ($li_dateDifference > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * Function for check the specific staff apply or not of a specific shift
     */

    public static function checkLoginPerson($lv_loginType) {
        if ($lv_loginType != 'C') {
            return 1;
        } else {
            return 0;
        }
    }

    public static function checkLoginPersonCoordinatorAndManager($lv_loginType) {
        if ($lv_loginType != 'C' && $lv_loginType != 'M') {
            return 1;
        } else {
            return 0;
        }
    }

    public static function checkBookingApplyStatus($li_shiftId, $li_staff_id) {
        $sqlQuery = "SELECT * FROM {{booking}} WHERE `staff_id` = " . $li_staff_id . " AND `staff_request_id` = " . $li_shiftId;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if (count($command) == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function getUpcomingBookingForStaff($li_staff_id) {
        $date = date('Y-m-d H:i:s');
        $array = array();
        $i = 0;
        $sqlQuery = "SELECT booking_id FROM {{booking}}, {{shift_management_for_hospital}} WHERE {{booking}}.staff_request_id = {{shift_management_for_hospital}}.staff_request_id AND {{booking}}.cancel_by_whom = 0 AND {{booking}}.staff_id = " . $li_staff_id . " AND {{shift_management_for_hospital}}.shift_start_datetime > '" . $date . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        foreach ($command as $lv_staffBookingId) {
            $array[$i++] = $lv_staffBookingId['booking_id'];
        }
//        print_r($array);die;
        return $array;
    }

    public static function getPreviousBookingForStaff($li_staff_id) {
        $date = date('Y-m-d H:i:s');
        $array = array();
        $i = 0;
        $sqlQuery = "SELECT booking_id FROM {{booking}}, {{shift_management_for_hospital}} WHERE {{booking}}.staff_request_id = {{shift_management_for_hospital}}.staff_request_id AND {{booking}}.cancel_by_whom = 0 AND {{booking}}.staff_id = " . $li_staff_id . " AND {{shift_management_for_hospital}}.shift_start_datetime < '" . $date . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        foreach ($command as $lv_staffBookingId) {
            $array[$i++] = $lv_staffBookingId['booking_id'];
        }
//        print_r($array);die;
        return $array;
    }

    public static function getCancelledBookingForStaff($li_staff_id) {
        $array = array();
        $i = 0;
        $sqlQuery = "SELECT booking_id FROM {{booking}}, {{shift_management_for_hospital}} WHERE {{booking}}.staff_request_id = {{shift_management_for_hospital}}.staff_request_id AND {{booking}}.cancel_by_whom != 0 AND {{booking}}.staff_id = " . $li_staff_id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        foreach ($command as $lv_staffBookingId) {
            $array[$i++] = $lv_staffBookingId['booking_id'];
        }
//        print_r($array);die;
        return $array;
    }

    public static function getShiftAppliedFor($li_staff_id) {
        $array = array();
        $i = 0;
        $sqlQuery = "SELECT `enquiry_id` FROM {{shift_enquiry_ack}} WHERE `is_confirmed` = 'N' AND `availability_confirmed_via` = 'Dashboard' AND `availability_confirmed_by_staff` = 'Y' AND `staff_id` = " . $li_staff_id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        foreach ($command as $lv_staffBookingId) {
            $array[$i++] = $lv_staffBookingId['enquiry_id'];
        }
//        print_r($array);
//        die;
        return $array;
    }

    public static function getEnquiredShiftForYou($li_staff_id) {
        $array = array();
        $i = 0;
        $toDay = date("Y-m-d h:i:s");
        $sqlQuery = "SELECT `enquiry_id` FROM {{shift_enquiry_ack}} ack, {{shift_management_for_hospital}} s WHERE ack.staff_request_id = s.staff_request_id AND ack.availability_confirmed_by_staff = 'N' AND s.shift_start_datetime > '" . $toDay . "' AND ack.staff_id = " . $li_staff_id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        foreach ($command as $lv_staffBookingId) {
            $array[$i++] = $lv_staffBookingId['enquiry_id'];
        }
        return $array;
    }

    public static function checkStatus($lv_status) {
        $la_status = YII::app()->params['status'];
        foreach ($la_status as $x => $x_value) {
            if ($x == $lv_status) {
                $lv_status_return = $x_value;
            }
        }
        return $lv_status_return;
    }

    public static function checkStaffType($lv_status) {
        $la_status = YII::app()->params['staffType'];
        foreach ($la_status as $x => $x_value) {
            if ($x == $lv_status) {
                $lv_status_return = $x_value;
            }
        }
        return $lv_status_return;
    }

    public static function checkFulfillStatus($lv_staffRequestId) {
        $sqlQuery = "SELECT * FROM `ams_shift_management_for_hospital` WHERE `staff_request_id`='" . $lv_staffRequestId . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($command[0]['quantity'] == $command[0]['quantity_confirmed']) {
            $lv_status_return = 'Fulfilled';
        } else {
            $lv_status_return = 'Not Fulfilled';
        }
        return $lv_status_return;
    }

    public function getAvailableStaffReport($la_post) {
        $i = 0;
        if ($la_post['startDate'] != "") {
            $startDate = Utility::changeDateToMysql($la_post['startDate']);
        }
        if ($la_post['endDate'] != "") {
            $endDate = Utility::changeDateToMysql($la_post['endDate']);
        }
        if ($la_post['startTime'] != "") {
            $startTime = $la_post['startTime'];
        } else {
            $object = new DateTime();
            $object->setTime(00, 00, 00);
            $startTime = $object->format('H:i:s');
        }
        if ($la_post['endTime'] != "") {
            $endTime = $la_post['endTime'];
        } else {
            $object = new DateTime();
            $object->setTime(23, 59, 59);
            $endTime = $object->format('H:i:s');
        }
        $staffs = array();
        $sqlQuery = "SELECT * FROM {{staff_registration}} s, {{user}} u WHERE s.staff_status = 'A' AND u.type != 'A' AND s.staff_id = u.staff_id AND s.visa_expiry_date > '" . $endDate . "' AND s.dbs_expiry > '" . $endDate . "'";
        if ($la_post['staff'] != "") {
            $sqlQuery.= "AND s.staff_id='" . $la_post['staff'] . "'";
        }
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if (count($command) != 0)
            foreach ($command as $rec) {
                $user_id = $rec['id'];
                $sqlQuery = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $user_id . " AND `date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND '" . $startTime . "'  BETWEEN r.start_time AND r.end_time
                                        UNION 
                                        SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $user_id . " AND `date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND '" . $endTime . "'  BETWEEN r.start_time AND r.end_time
                                        UNION
                                        SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $user_id . " AND `date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND '" . $startTime . "' <= r.start_time AND r.start_time<='" . $endTime . "'
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE '" . $startDate . "' BETWEEN `start_date` AND `end_date` AND `staff_id` = " . $user_id;
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                if (count($command) == 0) {
                    $staffs[$i++] = $rec;
                }
            }
        return $staffs;
    }

    public static function convertToCsv($la_inputArray, $ls_outputFileName, $ls_delimiter) {
        /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
        $ls_ext = strtolower(end(explode('.', $ls_outputFileName)));
        if (!@in_array($ls_ext, array('csv', 'xls', 'xlsx'))) {
            $ls_outputFileName.='.csv';
        }
        $f = fopen('php://memory', 'w');
        /** loop through array  */
        foreach ($la_inputArray as $line) {
            /** default php csv handler * */
            fputcsv($f, $line, $ls_delimiter);
        }
        /** rewrind the "file" with the csv lines * */
        fseek($f, 0);
        /** modify header to be downloadable csv file * */
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $ls_outputFileName . '";');
        /** Send file to browser for download */
        fpassthru($f);
    }

    public static function getCoordinator() {
        $sqlQuery = "SELECT * FROM {{user}} WHERE `type`= 'C' AND `active_status` = 'Y'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        return $command;
    }

    public static function getRelevantCoordinator($id) {
        $sqlQuery = "SELECT * FROM {{user}} WHERE `type`= 'C' AND `active_status` = 'Y' AND `id` = '" . $id . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        return $command;
    }

    public static function getStaff($staff_id) {
        $sqlQueryUser = "SELECT `first_name`, `email`, `mobile` FROM {{user}} WHERE `id` = '" . $staff_id . "'";
        $commandUser = Yii::app()->db->createCommand($sqlQueryUser)->queryAll();
        return $commandUser;
    }

    public static function changeContactNumberMail() {
        $coordinator = Utility::getCoordinator();
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'staff change their Mobile no'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $ls_mobile = '';
        foreach ($coordinator AS $lv_coordinator) {
            $to = $lv_coordinator['email'];
            $headers = self::setMailHeader();
            $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
            $ls_subject = self::generateDynamicEmailContent($command[0]['subject'], $_SESSION['logged_user']);
            $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $_SESSION['logged_user']);
            $ls_message = "<p><h2>Hi! " . $lv_coordinator['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
            self::sendEmail($to, $ls_subject, $ls_message, $headers);
            $ls_mobile .= ($ls_mobile == "") ? $lv_coordinator['mobile'] : ',' . $lv_coordinator['mobile'];
        }
        /*         * ********** */
//        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $_SESSION['logged_user']);
//        self::sendSMS($ls_messageSms, $ls_mobile);
        /*         * ********** */
    }

    public static function applyHolidayMail() {
        $coordinator = Utility::getCoordinator();
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Apply holiday'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $ls_mobile = '';
        foreach ($coordinator AS $lv_coordinator) {
            $to = $lv_coordinator['email'];
            $headers = self::setMailHeader();
            $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
            $ls_subject = self::generateDynamicEmailContent($command[0]['subject'], $_SESSION['logged_user']);
            $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $_SESSION['logged_user']);
            $ls_message = "<p><h2>Hi! " . $lv_coordinator['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
            self::sendEmail($to, $ls_subject, $ls_message, $headers);
            $ls_mobile .= ($ls_mobile == "") ? $lv_coordinator['mobile'] : ',' . $lv_coordinator['mobile'];
        }
        /*         * ********** */
//        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $_SESSION['logged_user']);
//        self::sendSMS($ls_messageSms, $ls_mobile);
        /*         * ********** */
    }

    public static function applyNonAvailabilityMail() {
        $coordinator = Utility::getCoordinator();
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Apply Non-Availability'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $ls_mobile = '';
        foreach ($coordinator AS $lv_coordinator) {
            $to = $lv_coordinator['email'];
            $headers = self::setMailHeader();
            $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
            $ls_subject = self::generateDynamicEmailContent($command[0]['subject'], $_SESSION['logged_user']);
            $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $_SESSION['logged_user']);
            $ls_message = "<p><h2>Hi! " . $lv_coordinator['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
            self::sendEmail($to, $ls_subject, $ls_message, $headers);
            $ls_mobile .= ($ls_mobile == "") ? $lv_coordinator['mobile'] : ',' . $lv_coordinator['mobile'];
        }
        /*         * ********** */
//        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $_SESSION['logged_user']);
//        self::sendSMS($ls_messageSms, $ls_mobile);
        /*         * ********** */
    }

    public static function staffStatusMail($staffStatus, $email, $mobile, $fName) {
        if ($staffStatus == 'A') {
            $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Create staffs'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $to = $email . "\r\n";
            $headers = self::setMailHeader();
            $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
            $ls_subject = $command[0]['subject'];
            $ls_mailContent = $command[0]['body'];
            $ls_message = "<p><h2>Hi! " . $fName . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
//            self::sendEmail($to, $ls_subject, $ls_message, $headers);
        } elseif ($staffStatus == 'Ar') {
            $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Archive staffs'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $to = $email . "\r\n";
            $headers = self::setMailHeader();
            $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
            $ls_subject = $command[0]['subject'];
            $ls_mailContent = $command[0]['body'];
            $ls_message = "<p><h2>Hi! " . $fName . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
            self::sendEmail($to, $ls_subject, $ls_message, $headers);
        }
        /*         * ********** */
//        $lo_staffDetails = StaffRegistration::model()->findByAttributes("email='" . $email . "'");
//        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $lo_staffDetails);
        $lo_staffDetails = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `email` = '" . $email . "'")->queryAll();
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $lo_staffDetails[0]);
//        self::sendSMS($ls_messageSms, $mobile);
        /*         * ********** */
    }

    public static function sendEnquiryMail($data, $fName, $email, $mobile, $coordinatorMobileNumber) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Shift enquiry'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $email;
        $headers = self::setMailHeader();
        $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
        $ls_subject = $command[0]['subject'];
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $fName . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
        /*         * ********** */
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
        //self::sendSMS($ls_messageSms, $mobile);
        self::sendSMS($ls_messageSms, $mobile, $coordinatorMobileNumber);
        /*         * ********** */
    }

    public static function sendEnquiryMailForApp($data, $fName, $email, $mobile, $coordinatorMobileNumber, $logged_user_email) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Shift enquiry'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $email;
        $subject = $command[0]['subject'];
        $headers = self::setMailHeader();
        $headers .= "From: <" . $logged_user_email . ">" . "\r\n";
        $ls_subject = $command[0]['subject'];
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $fName . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
        /*         * ********** */
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
        //self::sendSMS($ls_messageSms, $mobile);
        self::sendSMS($ls_messageSms, $mobile, $coordinatorMobileNumber);
        /*         * ********** */
    }

    public static function sendCancellationMail($data, $fName, $email, $mobile, $coordinatorMobileNumber) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Shift cancellation'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $email;
        $headers = self::setMailHeader();
        $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
        $ls_subject = self::generateDynamicEmailContent($command[0]['subject'], $data);
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $fName . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
        /*         * ********** */
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
        self::sendSMS($ls_messageSms, $mobile, $coordinatorMobileNumber);
        /*         * ********** */
    }

    public static function bookingShiftMail($data, $commandUser, $coordinatorMobileNumber) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Booking Shift'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $commandUser[0]['email'];
        $headers = self::setMailHeader();
        $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
        $ls_subject = self::generateDynamicEmailContent($command[0]['subject'], $data);
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $commandUser[0]['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
        /*
         * client requirement
         */
        $data['shift_end_datetime'] = Utility::changeTimeFromDateToUK($data['shift_end_datetime']);
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
        self::sendSMS($ls_messageSms, $commandUser[0]['mobile'], $coordinatorMobileNumber);
    }

    public static function applyForShiftMail($data, $coordinator) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Apply For Shift'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        foreach ($coordinator AS $lv_coordinator) {
            $to = $lv_coordinator['email'];
            $headers = self::setMailHeader();
            $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
            $ls_subject = $command[0]['subject'];
            $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
            $ls_message = "<p><h2>Hi! " . $lv_coordinator['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
            self::sendEmail($to, $ls_subject, $ls_message, $headers);
            $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
            self::sendSMS($ls_messageSms, $lv_coordinator['mobile'], $data['mobile']);
            //self::sendSMS($ls_messageSms, $lv_coordinator['mobile']);
        }
    }

    public static function cancelShiftMail($data, $coordinator) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Upcoming shift cancelled by staff'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        foreach ($coordinator AS $lv_coordinator) {
            $to = $lv_coordinator['email'];
            $headers = self::setMailHeader();
            $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
            $ls_subject = self::generateDynamicEmailContent($command[0]['subject'], $data);
            $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
            $ls_message = "<p><h2>Hi! " . $lv_coordinator['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
            self::sendEmail($to, $ls_subject, $ls_message, $headers);
            $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
            self::sendSMS($ls_messageSms, $lv_coordinator['mobile'], $data['mobile']);
            //self::sendSMS($ls_messageSms, $lv_coordinator['mobile']);
        }
    }

    public static function expiryMail($data) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Expiry Notifications'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $data['email'];
        $headers = self::setMailHeader();
        $headers .= "From: <donotreply@ams.com>" . "\r\n";
        $ls_subject = $command[0]['subject'];
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $data['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
    }

    public static function expiryRenewalMail($data) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Re-validation renewal notifications'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $data['email'];
        $headers = self::setMailHeader();
        $headers .= "From: <donotreply@ams.com>" . "\r\n";
        $ls_subject = $command[0]['subject'];
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $data['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
    }

    public static function reminderMail($data) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Send Upcoming confirmed shift'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $data['email'];
        $headers = self::setMailHeader();
        $headers .= "From: <donotreply@ams.com>" . "\r\n";
        $ls_subject = $command[0]['subject'];
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        echo $ls_message = "<p><h2>Hi! " . $data['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
    }

    public static function enquiryToAllMail($data) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Send enquiry to all'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $data['email'];
        $headers = self::setMailHeader();
        $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
        $ls_subject = $command[0]['subject'];
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $data['first_name'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
        /*         * ********** */
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
        self::sendSMS($ls_messageSms, $data['mobile']);
    }

    public static function hospitalReminderMail($data) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Staff confirmation '";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $to = $data['email'];
        $headers = self::setMailHeader();
        $headers .= "From: <donotreply@ams.com>" . "\r\n";
        $ls_subject = $command[0]['subject'];
        $ls_mailContent = self::generateDynamicEmailContent($command[0]['body'], $data);
        $ls_message = "<p><h2>Hi! " . $data['hospital_unit'] . "</h2></p><p><span>" . $ls_mailContent . "</span></p>";
        self::sendEmail($to, $ls_subject, $ls_message, $headers);
    }

    public static function reminderSMS($data) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Send Upcoming confirmed shift'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
        self::sendSMS($ls_messageSms, $data['mobile']);
    }

    public static function hospitalReminderSMS($data) {
        $sqlQuery = "SELECT * FROM {{notification_template}} WHERE `name`= 'Staff confirmation '";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $ls_messageSms = self::generateDynamicEmailContent($command[0]['sms_body'], $data);
        self::sendSMS($ls_messageSms, $data['mobile']);
    }

    public function sendEmail($to, $ls_subject, $ls_message, $headers) {
        $model = new NotificationLog;
        $model->notification_type = "Mail";
        $model->send_to = $to;
        $model->send_from = "Ivers Care";
        $model->notification_sub = $ls_subject;
        $model->notification_body = $ls_message;
        $model->send_datetime = date('Y-m-d H:i:s');
        $model->ip = $_SERVER['REMOTE_ADDR'];
        $model->save();

        mail($to, $ls_subject, $ls_message, $headers);
        return TRUE;
    }

    public function setMailHeader() {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        return $headers;
    }

    public static function generateDynamicEmailContent($ls_text, $result) {
        $ls_text = str_replace("[WEBSITE_LINK]", Yii::app()->params['website'], $ls_text);
        foreach ($result as $key => $val) {
            $ls_customizedVarName = "[" . ${key} . "]";
            $ls_text = str_replace($ls_customizedVarName, $val, $ls_text);
        }
        return $ls_text;
    }

//    public static function sendSMS($message, $numbers, $senderMobileNumber = "") {
//
//        $model = new NotificationLog;
//        $model->notification_type = "SMS";
//        $model->send_to = $numbers;
//        if ($senderMobileNumber == "") {
//            $model->send_from = "Ivers Care";
//        } else {
//            $model->send_from = $senderMobileNumber;
//        }
//        $model->notification_sub = "No Subject";
//        $model->notification_body = $message;
//        $model->send_datetime = date('Y-m-d H:i:s');
//        $model->ip = $_SERVER['REMOTE_ADDR'];
//        $model->save();
//        // Authorisation details.
//
//        $username = Yii::app()->params['textLocal']['username'];
//        if ($senderMobileNumber == "") {
//            $sender = "Ivers Care"; // This is who the message appears to be from.
//        } else {
//            $sender = $senderMobileNumber;
//        }
//
//        $hash = Yii::app()->params['textLocal']['hash'];
//
//        // Config variables. Consult http://api.txtlocal.com/docs for more info.
//        $test = "0";
//
//        // Data for text message. This is the text message data.
//        //$numbers = "44777000000"; // A single number or a comma-seperated list of numbers
//        //$message = "This is a test message from the PHP API script.";
//        // 612 chars or less
//        // A single number or a comma-seperated list of numbers
//        $message = urlencode($message);
//        $data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
//
//
//
//        $ch = curl_init('http://api.txtlocal.com/send/?');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $result = curl_exec($ch); // This is the result from the API
//        curl_close($ch);
////        die($data);
//    }
    public static function sendSMS($message, $numbers, $senderMobileNumber = "") {
        $model = new NotificationLog;
        $model->notification_type = "SMS";
        $model->send_to = $numbers;
        if ($senderMobileNumber == "") {
            $model->send_from = "Ivers Care";
        } else {
            $model->send_from = $senderMobileNumber;
        }
        $model->notification_sub = "No Subject";
        $model->notification_body = $message;
        $model->send_datetime = date('Y-m-d H:i:s');
        $model->ip = $_SERVER['REMOTE_ADDR'];
        $model->save();
//        wDebug::debugObject($message);
        return TRUE;
    }

    public function getAreaForStaff($lv_vid) {
        $command = Yii::app()->db->createCommand("SELECT area_name FROM  {{staff_registration}}, {{staff_registration_preferred_work_area_map_table}}, {{work_area}} WHERE  {{work_area}}.work_area_id={{staff_registration_preferred_work_area_map_table}}.work_area_id AND {{staff_registration_preferred_work_area_map_table}}.staff_id={{staff_registration}}.staff_id AND {{staff_registration}}.staff_id='" . $lv_vid . "'")->queryAll();
        $area = '';
        foreach ($command as $k) {
            if ($area != '')
                $area.=', ';
            foreach ($k as $lo_user) {
                $area.=$lo_user;
            }
        }
        //die();
        return $area;
    }

    public function getStaffList($ls_area) {
        $array = array();
        $i = 0;
        $la_areaName = explode(',', $ls_area);
        $ls_areaCond = '';
        foreach ($la_areaName as $val) {
            $val = trim($val);
            if ($ls_areaCond == '') {
                $ls_areaCond = " sw.area_name LIKE '%" . $val . "%'";
            } else {
                $ls_areaCond.= " OR sw.area_name LIKE '%" . $val . "%'";
            }
        }
        $command = Yii::app()->db->createCommand("SELECT work_area_id FROM {{work_area}} sw WHERE   " . $ls_areaCond)->queryAll();
        foreach ($command as $li_Area) {
            $commandForStaffId = Yii::app()->db->createCommand("SELECT staff_id FROM  {{staff_registration_preferred_work_area_map_table}} srw WHERE  srw.work_area_id='" . $li_Area['work_area_id'] . "'")->queryAll();
            foreach ($commandForStaffId as $li_staffId) {
                if (!in_array($li_staffId['staff_id'], $array)) {
                    $array[$i++] = $li_staffId['staff_id'];
                }
            }
        }
        return $array;
    }

//    public function getStaffList($ls_area) {
//        $array = array();
//        $i = 0;
//        $ls_areaList = $ls_area;
//        $ls_findChar = ',';
//        $li_charPos = strpos($ls_areaList, $ls_findChar);
//        if ($li_charPos === false) {
//            $command = Yii::app()->db->createCommand("SELECT work_area_id FROM {{work_area}} sw WHERE  sw.area_name LIKE '%" . $ls_area . "%'")->queryAll();
//
//            foreach ($command as $li_Area) {
//                $commandForStaffId = Yii::app()->db->createCommand("SELECT staff_id FROM  {{staff_registration_preferred_work_area_map_table}} srw WHERE  srw.work_area_id='" . $li_Area['work_area_id'] . "'")->queryAll();
//                foreach ($commandForStaffId as $li_staffId) {
//                    if (!in_array($li_staffId['staff_id'], $array)) {
//                        $array[$i++] = $li_staffId['staff_id'];
//                    }
//                }
//            }
//        } else {
//            $la_getArea = array();
//            $la_getArea = explode(" ", $ls_areaList);
//            $ls_searchArea = '';
//            foreach ($la_getArea AS $ls_area) {
//                if ($ls_searchArea == '') {
//                    $ls_searchArea = " sw.area_name LIKE '%" . trim($ls_area) . "%'";
//                } else {
//
//                    $ls_searchArea.= " OR sw.area_name LIKE '%" . trim($ls_area) . "%'";
//                }
//            }
//
//            $command = Yii::app()->db->createCommand("SELECT work_area_id FROM {{work_area}} sw WHERE   " . $ls_searchArea)->queryAll();
//
//            foreach ($command as $li_Area) {
//                $commandForStaffId = Yii::app()->db->createCommand("SELECT staff_id FROM  {{staff_registration_preferred_work_area_map_table}} srw WHERE  srw.work_area_id='" . $li_Area['work_area_id'] . "'")->queryAll();
//                foreach ($commandForStaffId as $li_staffId) {
//                    if (!in_array($li_staffId['staff_id'], $array)) {
//                        $array[$i++] = $li_staffId['staff_id'];
//                    }
//                }
//            }
//        }
//        return $array;
//    }    
    public static function getWeekDate() {
        $start_date = strtotime("01 Aug 2016");

        $date = date('Y-m-d');
        $li_dateNumber = date('w', strtotime($date));
        if ($li_dateNumber > 3) {
            $end_date = strtotime("now");
            $end_date = strtotime('last wednesday', $end_date);
        } else if (($li_dateNumber < 3) && ($li_dateNumber >= 0)) {
            $end_date = strtotime("now");
            $end_date = strtotime('next wednesday', $end_date);
        } else if ($li_dateNumber == 3) {
            $end_date = strtotime("now");
        }

        $la_getDateArray = array();
        while (1) {
            $start_date = strtotime('next sunday', $start_date);
            if ($start_date > $end_date)
                break;
            $key = date("Y-m-d", $start_date);
            $value = Utility::changeDateToUK(date("Y-m-d", $start_date));
            $la_getDateArray[$key] = $value;
        }
        return array_reverse($la_getDateArray);
    }

    public static function checkDuplicateShifts($li_staff_id, $ld_weekEndDate) {
        $la_result = array();
        $la_result['monday'] = 0;
        $la_result['tuesday'] = 0;
        $la_result['wednesday'] = 0;
        $la_result['thursday'] = 0;
        $la_result['friday'] = 0;
        $la_result['saturday'] = 0;
        $la_result['sunday'] = 0;
        $sqlQueryForCheck = "SELECT * FROM {{timesheet}} t WHERE t.staff_id = '" . $li_staff_id . "' AND t.week_end_date = '" . $ld_weekEndDate . "'";
        $commandForCheck = Yii::app()->db->createCommand($sqlQueryForCheck)->queryAll();
        if (count($commandForCheck) != 0) {
            foreach ($commandForCheck AS $la_value) {
                if ($la_value['monday'] != 0) {
                    $la_result['monday'] = 1;
                }
                if ($la_value['tuesday'] != 0) {
                    $la_result['tuesday'] = 1;
                }
                if ($la_value['wednesday'] != 0) {
                    $la_result['wednesday'] = 1;
                }
                if ($la_value['thursday'] != 0) {
                    $la_result['thursday'] = 1;
                }
                if ($la_value['friday'] != 0) {
                    $la_result['friday'] = 1;
                }
                if ($la_value['saturday'] != 0) {
                    $la_result['saturday'] = 1;
                }
                if ($la_value['sunday'] != 0) {
                    $la_result['sunday'] = 1;
                }
            }
        }
        return $la_result;
    }

    public static function checkDuplicateShiftsInUpdate($li_staff_id, $ld_weekEndDate, $id) {
        $la_result = array();
        $la_result['monday'] = 0;
        $la_result['tuesday'] = 0;
        $la_result['wednesday'] = 0;
        $la_result['thursday'] = 0;
        $la_result['friday'] = 0;
        $la_result['saturday'] = 0;
        $la_result['sunday'] = 0;
        $sqlQueryForCheck = "SELECT * FROM {{timesheet}} t WHERE t.staff_id = '" . $li_staff_id . "' AND t.week_end_date = '" . $ld_weekEndDate . "' AND t.id != '" . $id . "'";
        $commandForCheck = Yii::app()->db->createCommand($sqlQueryForCheck)->queryAll();
        if (count($commandForCheck) != 0) {
            foreach ($commandForCheck AS $la_value) {
                if ($la_value['monday'] != 0) {
                    $la_result['monday'] = 1;
                }
                if ($la_value['tuesday'] != 0) {
                    $la_result['tuesday'] = 1;
                }
                if ($la_value['wednesday'] != 0) {
                    $la_result['wednesday'] = 1;
                }
                if ($la_value['thursday'] != 0) {
                    $la_result['thursday'] = 1;
                }
                if ($la_value['friday'] != 0) {
                    $la_result['friday'] = 1;
                }
                if ($la_value['saturday'] != 0) {
                    $la_result['saturday'] = 1;
                }
                if ($la_value['sunday'] != 0) {
                    $la_result['sunday'] = 1;
                }
            }
        }
        return $la_result;
    }

}

?>
