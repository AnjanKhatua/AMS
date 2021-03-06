<?php

class DefaultController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionreports() {
        $this->render('reports');
    }

    public function actionstaffRotaDetails() {
        $this->render('staffRota');
    }

    public function actionExpiry() {
        $la_staffStatus = YII::app()->params['staffStatus'];

        if ($_POST['expiry'] == "DBS_expiry") {
            if ($_POST['startDate'] != "") {
                $startDate = Utility::changeDateToMysql($_POST['startDate']);
            }
            if ($_POST['endDate'] != "") {
                $endDate = Utility::changeDateToMysql($_POST['endDate']);
            }
            $sqlQuery = "SELECT `first_name`, `last_name`, `dbs_number`, `dbs_issue_date`, `dbs_expiry`, `mobile_no`, `email`,`staff_status` FROM {{staff_registration}} WHERE `dbs_expiry`BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $i = 0;
            $outputArray = array();
            $outputArray[$i]['first_name'] = "First name";
            $outputArray[$i]['last_name'] = "Last name";
            $outputArray[$i]['dbs_number'] = "DBS number";
            $outputArray[$i]['dbs_issue_date'] = "DBS issue date";
            $outputArray[$i]['dbs_expiry'] = "DBS expiry date";

            $outputArray[$i]['mobile_no'] = "Mobile number";
            $outputArray[$i]['email'] = "Email";
            $outputArray[$i]['staff_status'] = "Status";



            $i++;
            $j = 0;

            foreach ($command as $value) {
                $outputArray[$i]['first_name'] = $command[$j]['first_name'];
                $outputArray[$i]['last_name'] = $command[$j]['last_name'];
                $outputArray[$i]['dbs_number'] = $command[$j]['dbs_number'];
                $outputArray[$i]['dbs_issue_date'] = Utility::changeDateToUK($command[$j]['dbs_issue_date']);
                $outputArray[$i]['dbs_expiry'] = Utility::changeDateToUK($command[$j]['dbs_expiry']);

                $outputArray[$i]['mobile_no'] = $command[$j]['mobile_no'];
                $outputArray[$i]['email'] = $command[$j]['email'];
                foreach ($la_staffStatus as $x => $x_value) {
                    if ($x == $command[$j]['staff_status']) {
                        $command[$j]['staff_status'] = $x_value;
                    }
                }
                $outputArray[$i]['staff_status'] = $command[$j]['staff_status'];

                $i++;
                $j++;
            }
            $date = time();
            $lv_outputFile = "DBS Expiry - " . $date;
            $lv_delimiter = ",";

            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($_POST['expiry'] == "Visa_expiry") {
            if ($_POST['startDate'] != "") {
                $startDate = Utility::changeDateToMysql($_POST['startDate']);
            }
            if ($_POST['endDate'] != "") {
                $endDate = Utility::changeDateToMysql($_POST['endDate']);
            }
            $sqlQuery = "SELECT `first_name`, `last_name`, `visa_no`, `visa_type`, `visa_issue_date`, `visa_expiry_date`, `mobile_no`, `email`, `staff_status` FROM {{staff_registration}} WHERE `visa_expiry_date`BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $i = 0;
            $outputArray = array();
            $outputArray[$i]['first_name'] = "First name";
            $outputArray[$i]['last_name'] = "Last name";
            $outputArray[$i]['visa_no'] = "Visa number";
            $outputArray[$i]['visa_type'] = "Visa type";
            $outputArray[$i]['visa_issue_date'] = "Visa issue date";
            $outputArray[$i]['visa_expiry_date'] = "Visa expiry date";
            $outputArray[$i]['mobile_no'] = "Mobile number";
            $outputArray[$i]['email'] = "Email";
            $outputArray[$i]['staff_status'] = "Status";



            $i++;
            $j = 0;

            foreach ($command as $value) {
                $outputArray[$i]['first_name'] = $command[$j]['first_name'];
                $outputArray[$i]['last_name'] = $command[$j]['last_name'];
                $outputArray[$i]['visa_no'] = $command[$j]['visa_no'];
                $outputArray[$i]['visa_type'] = $command[$j]['visa_type'];
                $outputArray[$i]['visa_issue_date'] = Utility::changeDateToUK($command[$j]['visa_issue_date']);
                $outputArray[$i]['visa_expiry_date'] = Utility::changeDateToUK($command[$j]['visa_expiry_date']);
                $outputArray[$i]['mobile_no'] = $command[$j]['mobile_no'];
                $outputArray[$i]['email'] = $command[$j]['email'];
                foreach ($la_staffStatus as $x => $x_value) {
                    if ($x == $command[$j]['staff_status']) {
                        $command[$j]['staff_status'] = $x_value;
                    }
                }
                $outputArray[$i]['staff_status'] = $command[$j]['staff_status'];


                $i++;
                $j++;
            }
            $date = time();
            $lv_outputFile = "Visa Expiry - " . $date;
            $lv_delimiter = ",";

            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($_POST['expiry'] == "Passport_expiry") {
            if ($_POST['startDate'] != "") {
                $startDate = Utility::changeDateToMysql($_POST['startDate']);
            }
            if ($_POST['endDate'] != "") {
                $endDate = Utility::changeDateToMysql($_POST['endDate']);
            }
            $sqlQuery = "SELECT `first_name`, `last_name`, `passport_no`, `passport_issue_date`, `passport_expiry_date`, `mobile_no`, `email`, `staff_status` FROM {{staff_registration}} WHERE `passport_expiry_date`BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $i = 0;
            $outputArray = array();
            $outputArray[$i]['first_name'] = "First name";
            $outputArray[$i]['last_name'] = "Last name";
            $outputArray[$i]['passport_no'] = "Passport number";
            $outputArray[$i]['passport_issue_date'] = "Passport issue date";
            $outputArray[$i]['passport_expiry_date'] = "Passport expiry date";
            $outputArray[$i]['mobile_no'] = "Mobile number";
            $outputArray[$i]['email'] = "Email";
            $outputArray[$i]['staff_status'] = "Status";

            $i++;
            $j = 0;

            foreach ($command as $value) {
                $outputArray[$i]['first_name'] = $command[$j]['first_name'];
                $outputArray[$i]['last_name'] = $command[$j]['last_name'];
                $outputArray[$i]['passport_no'] = $command[$j]['passport_no'];
                $outputArray[$i]['passport_issue_date'] = Utility::changeDateToUK($command[$j]['passport_issue_date']);
                $outputArray[$i]['passport_expiry_date'] = Utility::changeDateToUK($command[$j]['passport_expiry_date']);
                $outputArray[$i]['mobile_no'] = $command[$j]['mobile_no'];
                $outputArray[$i]['email'] = $command[$j]['email'];
                foreach ($la_staffStatus as $x => $x_value) {
                    if ($x == $command[$j]['staff_status']) {
                        $command[$j]['staff_status'] = $x_value;
                    }
                }
                $outputArray[$i]['staff_status'] = $command[$j]['staff_status'];


                $i++;
                $j++;
            }
            $date = time();
            $lv_outputFile = "Passport Expiry - " . $date;
            $lv_delimiter = ",";

            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($_POST['expiry'] == "Mandatory_training_expiry") {
            if ($_POST['startDate'] != "") {
                $startDate = Utility::changeDateToMysql($_POST['startDate']);
            }
            if ($_POST['endDate'] != "") {
                $endDate = Utility::changeDateToMysql($_POST['endDate']);
            }
            $sqlQuery = "SELECT `first_name`, `last_name`, `mobile_no`, `email`,`mandatory_training_expiry_date`,`staff_status` FROM {{staff_registration}} WHERE `mandatory_training_expiry_date` BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $i = 0;
            $outputArray = array();
            $outputArray[$i]['first_name'] = "First name";
            $outputArray[$i]['last_name'] = "Last name";
            $outputArray[$i]['mobile_no'] = "Mobile number";
            $outputArray[$i]['email'] = "Email";
            $outputArray[$i]['mandatory_training_expiry_date'] = "Mandatory Training Expiry Date";
            $outputArray[$i]['staff_status'] = "Status";

            $i++;
            $j = 0;

            foreach ($command as $value) {
                $outputArray[$i]['first_name'] = $command[$j]['first_name'];
                $outputArray[$i]['last_name'] = $command[$j]['last_name'];
                $outputArray[$i]['mobile_no'] = $command[$j]['mobile_no'];
                $outputArray[$i]['email'] = $command[$j]['email'];
                $outputArray[$i]['mandatory_training_expiry_date'] = Utility::changeDateToUK($command[$j]['mandatory_training_expiry_date']);
                foreach ($la_staffStatus as $x => $x_value) {
                    if ($x == $command[$j]['staff_status']) {
                        $command[$j]['staff_status'] = $x_value;
                    }
                }
                $outputArray[$i]['staff_status'] = $command[$j]['staff_status'];


                $i++;
                $j++;
            }
            $date = time();
            $lv_outputFile = "Mandatory Training Expiry Date - " . $date;
            $lv_delimiter = ",";

            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($_POST['expiry'] == "Pmva_expiry") {
            if ($_POST['startDate'] != "") {
                $startDate = Utility::changeDateToMysql($_POST['startDate']);
            }
            if ($_POST['endDate'] != "") {
                $endDate = Utility::changeDateToMysql($_POST['endDate']);
            }
            $sqlQuery = "SELECT `first_name`, `last_name`, `pmva_expiry_date`, `mobile_no`, `email`,`staff_status` FROM {{staff_registration}} WHERE `pmva_expiry_date` BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $i = 0;
            $outputArray = array();
            $outputArray[$i]['first_name'] = "First name";
            $outputArray[$i]['last_name'] = "Last name";
            $outputArray[$i]['pmva_expiry_date'] = "Mva expiry date";
            $outputArray[$i]['mobile_no'] = "Mobile number";
            $outputArray[$i]['email'] = "Email";
            $outputArray[$i]['staff_status'] = "Status";

            $i++;
            $j = 0;

            foreach ($command as $value) {
                $outputArray[$i]['first_name'] = $command[$j]['first_name'];
                $outputArray[$i]['last_name'] = $command[$j]['last_name'];
                $outputArray[$i]['pmva_expiry_date'] = Utility::changeDateToUK($command[$j]['pmva_expiry_date']);
                $outputArray[$i]['mobile_no'] = $command[$j]['mobile_no'];
                $outputArray[$i]['email'] = $command[$j]['email'];
                foreach ($la_staffStatus as $x => $x_value) {
                    if ($x == $command[$j]['staff_status']) {
                        $command[$j]['staff_status'] = $x_value;
                    }
                }
                $outputArray[$i]['staff_status'] = $command[$j]['staff_status'];


                $i++;
                $j++;
            }
            $date = time();
            $lv_outputFile = "Mva Expiry - " . $date;
            $lv_delimiter = ",";

            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($_POST['expiry'] == "Maybo_expiry") {
            if ($_POST['startDate'] != "") {
                $startDate = Utility::changeDateToMysql($_POST['startDate']);
            }
            if ($_POST['endDate'] != "") {
                $endDate = Utility::changeDateToMysql($_POST['endDate']);
            }
            $sqlQuery = "SELECT `first_name`, `last_name`, `maybo_training_expiry`, `mobile_no`, `email`,`staff_status` FROM {{staff_registration}} WHERE `maybo_training_expiry`BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $i = 0;
            $outputArray = array();
            $outputArray[$i]['first_name'] = "First name";
            $outputArray[$i]['last_name'] = "Last name";
            $outputArray[$i]['maybo_training_expiry'] = "Maybo expiry date";
            $outputArray[$i]['mobile_no'] = "Mobile number";
            $outputArray[$i]['email'] = "Email";
            $outputArray[$i]['staff_status'] = "Status";

            $i++;
            $j = 0;

            foreach ($command as $value) {
                $outputArray[$i]['first_name'] = $command[$j]['first_name'];
                $outputArray[$i]['last_name'] = $command[$j]['last_name'];
                $outputArray[$i]['maybo_training_expiry'] = Utility::changeDateToUK($command[$j]['maybo_training_expiry']);
                $outputArray[$i]['mobile_no'] = $command[$j]['mobile_no'];
                $outputArray[$i]['email'] = $command[$j]['email'];
                foreach ($la_staffStatus as $x => $x_value) {
                    if ($x == $command[$j]['staff_status']) {
                        $command[$j]['staff_status'] = $x_value;
                    }
                }
                $outputArray[$i]['staff_status'] = $command[$j]['staff_status'];


                $i++;
                $j++;
            }
            $date = time();
            $lv_outputFile = "Maybo Expiry - " . $date;
            $lv_delimiter = ",";

            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($_POST['expiry'] == "Pin_expiry") {
            if ($_POST['startDate'] != "") {
                $startDate = Utility::changeDateToMysql($_POST['startDate']);
            }
            if ($_POST['endDate'] != "") {
                $endDate = Utility::changeDateToMysql($_POST['endDate']);
            }
            $sqlQuery = "SELECT `first_name`, `last_name`, `pin_expiry_date`, `mobile_no`, `email`,`staff_status` FROM {{staff_registration}} WHERE `pin_expiry_date`BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            $i = 0;
            $outputArray = array();
            $outputArray[$i]['first_name'] = "First name";
            $outputArray[$i]['last_name'] = "Last name";
            $outputArray[$i]['pin_expiry_date'] = "Pin expiry date";
            $outputArray[$i]['mobile_no'] = "Mobile number";
            $outputArray[$i]['email'] = "Email";
            $outputArray[$i]['staff_status'] = "Status";

            $i++;
            $j = 0;

            foreach ($command as $value) {
                $outputArray[$i]['first_name'] = $command[$j]['first_name'];
                $outputArray[$i]['last_name'] = $command[$j]['last_name'];
                $outputArray[$i]['pin_expiry_date'] = Utility::changeDateToUK($command[$j]['pin_expiry_date']);
                $outputArray[$i]['mobile_no'] = $command[$j]['mobile_no'];
                $outputArray[$i]['email'] = $command[$j]['email'];
                foreach ($la_staffStatus as $x => $x_value) {
                    if ($x == $command[$j]['staff_status']) {
                        $command[$j]['staff_status'] = $x_value;
                    }
                }
                $outputArray[$i]['staff_status'] = $command[$j]['staff_status'];


                $i++;
                $j++;
            }
            $date = time();
            $lv_outputFile = "Pin Expiry - " . $date;
            $lv_delimiter = ",";

            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        }
        $this->render('reports');
    }

    public function actionShiftAllocation() {
        if ($_POST['startDate'] != "") {
            $startDate = Utility::changeDateToMysql($_POST['startDate']);
        }
        if ($_POST['endDate'] != "") {
            $endDate = Utility::changeDateToMysql($_POST['endDate']);
        }
        $sqlQuery = "SELECT u.staff_id, u.first_name, u.last_name, r.max_allowed_hour, u.mobile, u.email, b.confirm_by_whom, b.confirmation_date, h.hospital_unit FROM {{user}} u, {{staff_registration}} r, {{booking}} b, {{shift_management_for_hospital}} s, {{hospital_unit}} h  WHERE b.staff_id = u.id AND u.staff_id = r.staff_id AND b.staff_request_id = s.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $i = 0;

        $outputArray = array();
        $outputArray[$i]['staff_id'] = "Staff id";
        $outputArray[$i]['first_name'] = "First name";
        $outputArray[$i]['last_name'] = "Last name";
        $outputArray[$i]['max_allowed_hour'] = "Max allowed hour";
        $outputArray[$i]['mobile'] = "Mobile number";
        $outputArray[$i]['email'] = "Email";
        $outputArray[$i]['confirm_by_whom'] = "Confirm by whom";
        $outputArray[$i]['confirmation_date'] = "Confirmation date";
        $outputArray[$i]['hospital_unit'] = "Hospital name";
        $i++;
        $j = 0;

        foreach ($command as $value) {
            $la_shiftType = YII::app()->params['staffType'];

            foreach ($la_shiftType as $x => $x_value) {
                if ($x == $command[$j]['confirm_by_whom']) {
                    $command[$j]['confirm_by_whom'] = $x_value;
                }
            }
            $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
            $outputArray[$i]['first_name'] = $command[$j]['first_name'];
            $outputArray[$i]['last_name'] = $command[$j]['last_name'];
            $outputArray[$i]['max_allowed_hour'] = $command[$j]['max_allowed_hour'];
            $outputArray[$i]['mobile'] = $command[$j]['mobile'];
            $outputArray[$i]['email'] = $command[$j]['email'];
            $outputArray[$i]['confirm_by_whom'] = $command[$j]['confirm_by_whom'];
            $outputArray[$i]['confirmation_date'] = Utility::changeDateToUK($command[$j]['confirmation_date']);
            $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];

            $i++;
            $j++;
        }
        $date = time();
        $lv_outputFile = "Shift Allocation - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function actionStaffAvailability() {

        $la_post = array();
        $la_result = array();
        $la_post = $_POST;
//        $li_time = microtime(true);
        $la_result = Utility::getAvailableStaffReport($la_post);

        $i = 0;
        $outputArray = array();
        $outputArray[$i]['first_name'] = "First name";
        $outputArray[$i]['last_name'] = "Last name";
        $outputArray[$i]['special_training'] = "Special training";
        $outputArray[$i]['max_allowed_hour'] = "Max allowed hour";
        $outputArray[$i]['mobile_no'] = "Mobile number";
        $outputArray[$i]['email'] = "Email";
        $outputArray[$i]['post_code'] = "Post code";
        $outputArray[$i]['visa_expiry_date'] = "Visa expiry date";
        $outputArray[$i]['dbs_expiry'] = "DBS expiry date";
        $outputArray[$i]['preferred_work_area'] = "Preferred work area";
        $i++;


        foreach ($la_result as $rec) {
            $lv_workArea = "";
            $lv_jobType = "";
            $sqlQuery = "SELECT `area_name` FROM {{work_area}} w, {{staff_registration_preferred_work_area_map_table}} s WHERE s.work_area_id = w.work_area_id AND s.staff_id = " . $rec['staff_id'];
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            foreach ($command as $rec1) {
                if ($lv_workArea != "")
                    $lv_workArea.=", ";
                $lv_workArea.=$rec1['area_name'];
            }

            $sqlQuery1 = "SELECT `job_type` FROM {{job_type}} j, {{staff_job_type_map}} s WHERE j.job_type_id = s.job_type_id AND s.staff_id = " . $rec['staff_id'];
            $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
            foreach ($command1 as $rec2) {
                if ($lv_jobType != "")
                    $lv_jobType.=", ";
                $lv_jobType.=$rec2['job_type'];
            }
            $outputArray[$i]['first_name'] = $rec['first_name'];
            $outputArray[$i]['last_name'] = $rec['last_name'];
            $outputArray[$i]['special_training'] = $lv_jobType;
            $outputArray[$i]['max_allowed_hour'] = $rec['max_allowed_hour'];
            $outputArray[$i]['mobile_no'] = $rec['mobile_no'];
            $outputArray[$i]['email'] = $rec['email'];
            $outputArray[$i]['post_code'] = $rec['post_code'];
            $outputArray[$i]['visa_expiry_date'] = Utility::changeDateToUK($rec['visa_expiry_date']);
            $outputArray[$i]['dbs_expiry'] = Utility::changeDateToUK($rec['dbs_expiry']);
            $outputArray[$i]['preferred_work_area'] = $lv_workArea;
            $i++;
        }
//   $li_time = microtime(true) -  $li_time;
//   die($li_time);
//        $sqlQuery = "SELECT * FROM {{non_availability_of_staff}} WHERE NOT (`start_date` BETWEEN '" . $startDate . "' AND '" . $endDate . "')";
//        print_r($command);
//        die;
        $date = time();
        $lv_outputFile = "Shift Availability - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function actionStaffCancelReport() {

        if ($_POST['startDate'] != "") {
            $startDate = Utility::changeDateToMysql($_POST['startDate']);
        }
        if ($_POST['endDate'] != "") {
            $endDate = Utility::changeDateToMysql($_POST['endDate']);
        }
        $sqlQuery = "SELECT u.first_name, u.last_name, u.email, u.mobile, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime, b.cancellation_date, b.cancellation_time, b.cancel_by_whom, b.cancel_requested_by FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} r WHERE r.staff_id = u.staff_id AND b.staff_id = u.id AND b.staff_request_id = s.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND b.cancel_requested_by != '' AND r.staff_id =" . $_POST['staff'];
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $i = 0;

        $outputArray = array();
        $outputArray[$i]['first_name'] = "First name";
        $outputArray[$i]['last_name'] = "Last name";
        $outputArray[$i]['email'] = "Email";
        $outputArray[$i]['mobile'] = "Mobile number";
        $outputArray[$i]['hospital_unit'] = "Hospital unit";
        $outputArray[$i]['shift_start_datetime'] = "Shift start datetime";
        $outputArray[$i]['shift_end_datetime'] = "Shift end datetime";
        $outputArray[$i]['cancellation_date'] = "Cancellation date";
        $outputArray[$i]['cancellation_time'] = "Cancellation time";
        $outputArray[$i]['cancel_by_whom'] = "Cancel by whom";
        $outputArray[$i]['cancel_requested_by'] = "Cancel requested by";
        $i++;
        $j = 0;

        foreach ($command as $value) {
            $la_shiftType = YII::app()->params['staffType'];

            $sqlQuery = "SELECT `type` FROM {{user}} WHERE id = " . $command[$j]['cancel_by_whom'];
            $staffType = Yii::app()->db->createCommand($sqlQuery)->queryAll();

            foreach ($la_shiftType as $x => $x_value) {
                if ($x == $command[$j]['cancel_requested_by']) {
                    $command[$j]['cancel_requested_by'] = $x_value;
                }
            }

            foreach ($la_shiftType as $x => $x_value) {
                if ($x == $staffType[0]['type']) {
                    $command[$j]['cancel_by_whom'] = $x_value;
                }
            }

            $outputArray[$i]['first_name'] = $command[$j]['first_name'];
            $outputArray[$i]['last_name'] = $command[$j]['last_name'];
            $outputArray[$i]['email'] = $command[$j]['email'];
            $outputArray[$i]['mobile'] = $command[$j]['mobile'];
            $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
            $outputArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($command[$j]['shift_start_datetime']);
            $outputArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($command[$j]['shift_end_datetime']);
            $outputArray[$i]['cancellation_date'] = Utility::changeDateToUK($command[$j]['cancellation_date']);
            $outputArray[$i]['cancellation_time'] = $command[$j]['cancellation_time'];
            $outputArray[$i]['cancel_by_whom'] = $command[$j]['cancel_by_whom'];
            $outputArray[$i]['cancel_requested_by'] = $command[$j]['cancel_requested_by'];

            $i++;
            $j++;
        }

        $date = time();
        $lv_outputFile = "Shift Cancel Report - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function actionNotAllocatedStaffReport() {

//        print_r($_POST);die;
        if ($_POST['startDate'] != "") {
            $startDate = Utility::changeDateToMysql($_POST['startDate']);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($_POST['endDate'] != "") {
            $endDate = Utility::changeDateToMysql($_POST['endDate']);
            $object = new DateTime($endDate);
            $object->setTime(23, 59, 59);
            $endDate = $object->format('Y-m-d H:i:s');
        }

        $sqlQuery = "SELECT h.hospital_unit, w.ward_name, j.job_type, s.shift_start_datetime, s.shift_end_datetime FROM {{shift_management_for_hospital}} s, {{shift_enquiry_ack}} e, {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE s.staff_request_id = e.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND s.ward_id = w.ward_id AND e.confirmed_by = 'S' AND e.is_confirmed = 'N' AND u.staff_id = " . $_POST['staff'] . " AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;

        $outputArray = array();
        $outputArray[$i]['hospital_unit'] = "Hospital unit";
        $outputArray[$i]['ward_name'] = "Ward name";
        $outputArray[$i]['job_type'] = "Job type";
        $outputArray[$i]['shift_start_datetime'] = "Shift start datetime";
        $outputArray[$i]['shift_end_datetime'] = "Shift end datetime";

        $i++;
        $j = 0;

        foreach ($command as $value) {

            $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
            $outputArray[$i]['ward_name'] = $command[$j]['ward_name'];
            $outputArray[$i]['job_type'] = $command[$j]['job_type'];
            $outputArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($command[$j]['shift_start_datetime']);
            $outputArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($command[$j]['shift_end_datetime']);

            $i++;
            $j++;
        }

        $date = time();
        $lv_outputFile = "Not Allocated Staff Report - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function actionRotaReport() {
        if ($_POST['startDate'] != "") {
            $startDate = Utility::changeDateToMysql($_POST['startDate']);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($_POST['endDate'] != "") {
            $endDate = Utility::changeDateToMysql($_POST['endDate']);
            $object = new DateTime($endDate);
            $object->setTime(23, 59, 59);
            $endDate = $object->format('Y-m-d H:i:s');
        }

        $sqlQuery = "SELECT s.requested_date, s.requested_time, s.requested_person, s.requested_person_mobile_number, h.hospital_unit, j.job_type, s.shift_start_datetime, s.shift_end_datetime, u.first_name, u.last_name, u.mobile, b.confirmation_date, b.confirmation_time, b.confirm_by_whom, b.cancellation_date, b.cancellation_time, b.cancel_by_whom, b.cancel_requested_by FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND b.staff_id = u.id AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND h.hospital_unit_id IN (";
        $count = count($_POST['hospital']);
        $lvHospitalId = '';
        for ($i = 0; $i < $count; $i++) {
            if ($i != 0)
                $lvHospitalId .= ',';
            $lvHospitalId .= $_POST['hospital'][$i];
        }
        $lvHospitalId .= ")";
        $sqlQuery .= $lvHospitalId;

        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $i = 0;

        $outputArray = array();
        $outputArray[$i]['requested_date'] = "Requested date";
        $outputArray[$i]['requested_time'] = "Requested time";
        $outputArray[$i]['requested_person'] = "Requested person";
        $outputArray[$i]['requested_person_mobile_number'] = "Requested person mobile number";
        $outputArray[$i]['hospital_unit'] = "Hospital unit";
        $outputArray[$i]['job_type'] = "Grade";
        $outputArray[$i]['shift_start_date'] = "Shift start date";
        $outputArray[$i]['shift_end_date'] = "Shift end date";
        $outputArray[$i]['shift_start_time'] = "Shift start time";
        $outputArray[$i]['shift_end_time'] = "Shift end time";
        $outputArray[$i]['staff_name'] = "Staff name";
        $outputArray[$i]['mobile'] = "Staff mobile number";
        $outputArray[$i]['confirmation_date'] = "Confirmation date";
        $outputArray[$i]['confirmation_time'] = "Confirmation time";
        $outputArray[$i]['confirm_by_whom'] = "Confirm by whom";
        $outputArray[$i]['cancellation_date'] = "Cancellation date";
        $outputArray[$i]['cancellation_time'] = "Cancellation time";
        $outputArray[$i]['cancel_by_whom'] = "Cancel by whom";
        $outputArray[$i]['cancel_requested_by'] = "Cancel requested by";
        $i++;
        $j = 0;

        foreach ($command as $value) {

            $la_shiftType = YII::app()->params['staffType'];

            $sqlQuery = "SELECT `type` FROM {{user}} WHERE id = " . $command[$j]['cancel_by_whom'];
            $staffType = Yii::app()->db->createCommand($sqlQuery)->queryAll();

            foreach ($la_shiftType as $x => $x_value) {
                if ($x == $staffType[0]['type']) {
                    $command[$j]['cancel_by_whom'] = $x_value;
                }
            }
            foreach ($la_shiftType as $x => $x_value) {
                if ($x == $command[$j]['cancel_requested_by']) {
                    $command[$j]['cancel_requested_by'] = $x_value;
                }
            }

            foreach ($la_shiftType as $x => $x_value) {
                if ($x == $command[$j]['confirm_by_whom']) {
                    $command[$j]['confirm_by_whom'] = $x_value;
                }
            }

            $lv_staffName = $command[$j]['first_name'] . " " . $command[$j]['last_name'];
            $lv_shiftStartDate = substr($command[$j]['shift_start_datetime'], 0, 10);
            $lv_shiftStartTime = substr($command[$j]['shift_start_datetime'], 11);

            $lv_shiftEndDate = substr($command[$j]['shift_end_datetime'], 0, 10);
            $lv_shiftEndTime = substr($command[$j]['shift_end_datetime'], 11);

            if ($command[$j]['cancellation_time'] == "00:00:00") {
                $command[$j]['cancellation_time'] = "";
            }
            if ($command[$j]['cancel_by_whom'] == "0") {
                $command[$j]['cancel_by_whom'] = "";
            }

            $outputArray[$i]['requested_date'] = Utility::changeDateToUK($command[$j]['requested_date']);
            $outputArray[$i]['requested_time'] = $command[$j]['requested_time'];
            $outputArray[$i]['requested_person'] = $command[$j]['requested_person'];
            $outputArray[$i]['requested_person_mobile_number'] = $command[$j]['requested_person_mobile_number'];
            $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
            $outputArray[$i]['job_type'] = $command[$j]['job_type'];
            $outputArray[$i]['shift_start_date'] = Utility::changeDateToUK($lv_shiftStartDate);
            $outputArray[$i]['shift_end_date'] = Utility::changeDateToUK($lv_shiftEndDate);
            $outputArray[$i]['shift_start_time'] = $lv_shiftStartTime;
            $outputArray[$i]['shift_end_time'] = $lv_shiftEndTime;
            $outputArray[$i]['staff_name'] = $lv_staffName;
            $outputArray[$i]['mobile'] = $command[$j]['mobile'];
            $outputArray[$i]['confirmation_date'] = Utility::changeDateToUK($command[$j]['confirmation_date']);
            $outputArray[$i]['confirmation_time'] = $command[$j]['confirmation_time'];
            $outputArray[$i]['confirm_by_whom'] = $command[$j]['confirm_by_whom'];
            $outputArray[$i]['cancellation_date'] = Utility::changeDateToUK($command[$j]['cancellation_date']);
            $outputArray[$i]['cancellation_time'] = $command[$j]['cancellation_time'];
            $outputArray[$i]['cancel_by_whom'] = $command[$j]['cancel_by_whom'];
            $outputArray[$i]['cancel_requested_by'] = $command[$j]['cancel_requested_by'];

            $i++;
            $j++;
        }

        $date = time();
        $lv_outputFile = "Rota Report - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function actionServiceDetailsForAnyHospital() {

        if ($_POST['startDate'] != "") {
            $startDate = Utility::changeDateToMysql($_POST['startDate']);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($_POST['endDate'] != "") {
            $endDate = Utility::changeDateToMysql($_POST['endDate']);
            $object = new DateTime($endDate);
            $object->setTime(23, 59, 59);
            $endDate = $object->format('Y-m-d H:i:s');
        }

        $sqlQuery = "SELECT h.hospital_unit, u.first_name, u.last_name, j.job_type, s.shift_start_datetime, s.shift_end_datetime FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND b.staff_id = u.id AND b.cancel_by_whom = '0' AND s.hospital_unit_id = " . $_POST['hospital'] . " AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $sqlQueryTypeCount = "SELECT COUNT(j.job_type_id), j.job_type FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND b.staff_id = u.id AND b.cancel_by_whom = '0' AND s.hospital_unit_id = " . $_POST['hospital'] . " AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'GROUP BY j.job_type";
        $commandTypeCount = Yii::app()->db->createCommand($sqlQueryTypeCount)->queryAll();
//        print_r($commandTypeCount);die;
        $i = 0;

        $outputArray = array();
        $outputArray[$i]['staff_name'] = "Staff name";
        $outputArray[$i]['hospital_unit'] = "Hospital unit";
        $outputArray[$i]['job_type'] = "Job type";
        $outputArray[$i]['shift_start_datetime'] = "Shift start datetime";
        $outputArray[$i]['shift_end_datetime'] = "Shift end datetime";

        $i++;
        $j = 0;

        foreach ($command as $value) {
            $lv_staffName = $command[$j]['first_name'] . " " . $command[$j]['last_name'];

            $outputArray[$i]['staff_name'] = $lv_staffName;
            $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
            $outputArray[$i]['job_type'] = $command[$j]['job_type'];
            $outputArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($command[$j]['shift_start_datetime']);
            $outputArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($command[$j]['shift_end_datetime']);

            $i++;
            $j++;
        }

        $outputArray[$i]['staff_name'] = "";
        $outputArray[$i]['hospital_unit'] = "";
        $outputArray[$i]['job_type'] = "";
        $outputArray[$i]['shift_start_datetime'] = "";
        $outputArray[$i]['shift_end_datetime'] = "";
        $i++;
        $j = 0;
        foreach ($commandTypeCount as $value) {
            $outputArray[$i]['staff_name'] = "";
            $outputArray[$i]['hospital_unit'] = "Total shift covered by " . $commandTypeCount[$j]['job_type'];
            $outputArray[$i]['job_type'] = $commandTypeCount[$j]['COUNT(j.job_type_id)'];
            $outputArray[$i]['shift_start_datetime'] = "";
            $outputArray[$i]['shift_end_datetime'] = "";

            $i++;
            $j++;
        }

        $date = time();
        $lv_outputFile = "Service Details for any Hospital - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function actionStaffRota() {

        $userEmail = $_POST['staffEmail'];
        $startValue = strrpos($userEmail, "(") + 1;

        $ls_email = substr($userEmail, $startValue, -1);

        if ($_POST['startDate'] != "") {
            $startDate = Utility::changeDateToMysql($_POST['startDate']);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($_POST['endDate'] != "") {
            $endDate = Utility::changeDateToMysql($_POST['endDate']);
            $object = new DateTime($endDate);
            $object->setTime(23, 59, 59);
            $endDate = $object->format('Y-m-d H:i:s');
        }

        $sqlQuery = "SELECT u.first_name, u.last_name, u.email, h.hospital_unit, j.job_type, w.ward_name, s.shift_start_datetime, s.shift_end_datetime FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b, {{ward}} w WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND s.ward_id = w.ward_id AND b.staff_id = u.id AND b.cancel_by_whom = '0' AND u.email = '" . $ls_email . "' AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY s.shift_start_datetime";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($command);
//        die;
        $i = 0;

        $outputArray = array();
        $outputArray[$i]['staff_name'] = "Staff name";
        $outputArray[$i]['email'] = "Email";
        $outputArray[$i]['hospital_unit'] = "Hospital Name";
        $outputArray[$i]['job_type'] = "Job Type";
        $outputArray[$i]['ward_name'] = "Ward Name";
        $outputArray[$i]['shift_start_datetime'] = "Shift start datetime";
        $outputArray[$i]['shift_end_datetime'] = "Shift end datetime";

        $i++;
        $j = 0;

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

        $date = time();
        $lv_outputFile = "Staff Rota - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function actionautocomplete() {
        $searchTerm = $_GET['term'];

        $sqlQueryForUser = "SELECT * FROM {{user}} u WHERE u.type = 'S' AND u.email LIKE '%" . $searchTerm . "%' ORDER BY u.email";
        $commandForUser = Yii::app()->db->createCommand($sqlQueryForUser)->queryAll();

//        print_r($commandForUser);
        $data = array();
        foreach ($commandForUser AS $lo_user) {
//            $key = $lo_user['id'];
            $value = $lo_user['first_name'] . " " . $lo_user['last_name'] . " (" . $lo_user['email'] . ")";
            $data[] = $value;
        }
        //return json data
        echo json_encode($data);
    }

    public function actionautocompleteHospitalUnitName() {
        $searchTerm = $_GET['term'];

        $sqlQueryForHospital = "SELECT * FROM {{hospital_unit}} h WHERE h.hospital_unit_active_status = 'Y' AND h.hospital_unit LIKE '%" . $searchTerm . "%' ORDER BY h.hospital_unit";
        $commandForHospital = Yii::app()->db->createCommand($sqlQueryForHospital)->queryAll();

//        print_r($commandForUser);
        $data = array();
        foreach ($commandForHospital AS $lo_hospital) {
//            $key = $lo_user['id'];
            $value = $lo_hospital['hospital_unit'];
            $data[] = $value;
        }
        //return json data
        echo json_encode($data);
    }

    public function actioncheckemail() {
        $sqlQueryForEmail = "SELECT * FROM {{user}} u WHERE u.email = '" . $_GET['emailid'] . "'";
        $commandForEmail = Yii::app()->db->createCommand($sqlQueryForEmail)->queryAll();

        if (count($commandForEmail) == 0) {
            echo 'Please enter valid staff email';
        } else {
            echo 'success';
        }
    }

    public function actionautocompleteNameEmail() {
        $searchTerm = $_GET['term'];

        $sqlQueryForUser = "SELECT * FROM {{user}} u, {{staff_registration}} s WHERE s.staff_id = u.staff_id AND s.staff_status = 'A' AND u.type = 'S' AND (u.email LIKE '%" . $searchTerm . "%' OR u.first_name LIKE '%" . $searchTerm . "%' OR u.last_name LIKE '%" . $searchTerm . "%') ORDER BY u.email";
        $commandForUser = Yii::app()->db->createCommand($sqlQueryForUser)->queryAll();

        $data = array();
        foreach ($commandForUser AS $lo_user) {
            $value = $lo_user['first_name'] . " " . $lo_user['last_name'] . " (" . $lo_user['email'] . ")";
            $data[] = $value;
        }
        echo json_encode($data);
    }

    public function actionChangePassword() {
        $model = new ChangePassword;

        if (isset($_GET['email'])) {
            $model->email = $_GET['email'];
        }

        if (isset($_POST['ChangePassword']['email'])) {
            $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `email` = '" . $_POST['ChangePassword']['email'] . "'")->queryAll();
            $model->email = $_POST['ChangePassword']['email'];
        }

        if (($command[0]['type'] == 'D') && ($command[0]['id'] != $_SESSION['logged_user']['id'])) {
            $_SESSION['ChangePasswordMsgError'] = "You are not authenticate for that action!";
        } elseif (isset($_POST['ChangePassword']['email'])) {
            $ls_msg = Utility::validateEmailField($_POST['ChangePassword']['email']);
            if (isset($_POST['ChangePassword']['email']) && $ls_msg != "") {
                $model->addError('email', $ls_msg);
            }
            if (isset($command[0]) && (count($command[0]) != 0)) {
                $model->attributes = $_POST['ChangePassword'];
                if (isset($_POST['ChangePassword']) && ($_POST['ChangePassword']['new_password'] != $_POST['ChangePassword']['repeat_password'])) {
                    $model->addError('repeat_password', "New password and repeat password do not match!");
                } else {
                    $ls_newPassword = md5($_POST['ChangePassword']['new_password']);
                    $data = array(
                        "password" => $ls_newPassword
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_user', $data, 'email=:email', array(':email' => $_POST['ChangePassword']['email'])
                    );
                    $_SESSION['ChangePasswordMsg'] = "Your password has been successfully updated!";
                    $model->email = '';
                    $model->new_password = '';
                    $model->repeat_password = '';
                }
            } else {
                $model->addError('email', "Invalid email id!");
            }
        }
        $this->render('changePassword', array('model' => $model));
    }

}

?>