<?php

//*****  @package         Yii          *****//
//*****  @subpackage      Rest Server  *****//
//*****  @category        Model        *****//
//*****  @author          Md Ibrahim   *****//

class Custom {
    /*     * ****************STAFF SECTION******************* */
    /*     * ************************************************ */

    public function userLogin($la_loginData) {
//        print_r($la_loginData->email);die;
        $sqlQuery = "SELECT * FROM {{user}} WHERE `active_status`='Y'  AND `email`='" . $la_loginData->email . "' AND `password`='" . md5($la_loginData->password) . "' ";
        $la_loggedUserData = Yii::app()->db->createCommand($sqlQuery)->queryRow();
        if ($la_loggedUserData) {
            return $la_loggedUserData;
        } else {
            return 'fail';
        }
    }

    public function getStaffDetails($lo_staff_info) {
//        print_r($lo_staff_info->user_id);die;
        $sqlQuery_info = "SELECT * FROM {{staff_registration}} WHERE `staff_id` = " . $lo_staff_info->staff_id;
        $la_staffDetails = Yii::app()->db->createCommand($sqlQuery_info)->queryRow();
        if ($la_staffDetails) {
            $la_staffDetails['passport_expiry_date'] = Utility::changeDateToUK($la_staffDetails['passport_expiry_date']);
            $la_staffDetails['visa_expiry_date'] = Utility::changeDateToUK($la_staffDetails['visa_expiry_date']);
            $la_staffDetails['dbs_expiry'] = Utility::changeDateToUK($la_staffDetails['dbs_expiry']);
            $la_staffDetails['mandatory_training_expiry_date'] = Utility::changeDateToUK($la_staffDetails['mandatory_training_expiry_date']);
            $la_staffDetails['pmva_expiry_date'] = Utility::changeDateToUK($la_staffDetails['pmva_expiry_date']);
            $la_staffDetails['maybo_training_expiry'] = Utility::changeDateToUK($la_staffDetails['maybo_training_expiry']);
            $la_staffDetails['pin_expiry_date'] = Utility::changeDateToUK($la_staffDetails['pin_expiry_date']);

            $sqlQuery_user_image = "SELECT image FROM {{user}} WHERE `id` = " . $lo_staff_info->user_id;
            $ls_staffImage = Yii::app()->db->createCommand($sqlQuery_user_image)->queryRow();
            if ($ls_staffImage) {
                $la_staffDetails['image'] = $ls_staffImage['image'];
            } else {
                $la_staffDetails['image'] = "";
            }
        }
//        print_r($ls_staffImage);die;
        if ($la_staffDetails) {
            return $la_staffDetails;
        } else {
            return 'fail';
        }
    }

    public function changeUserImage($lo_staff_image_info) {
//        print_r($lo_staff_image_info);
        $sqlQuery_user_image = "SELECT image FROM {{user}} WHERE `id` = " . $lo_staff_image_info->user_id;
        $ls_staffImage = Yii::app()->db->createCommand($sqlQuery_user_image)->queryRow();
        if ($ls_staffImage['image'] != "1666-male.jpg" || $ls_staffImage['image'] != "2043-female.png") {
            @unlink(Yii::app()->basePath . '/../userImage/' . $ls_staffImage['image']);
        }
        if (isset($lo_staff_image_info->image) && $lo_staff_image_info->image != "") {
            $data = array(
                "image" => $lo_staff_image_info->image
            );
            $update = Yii::app()->db->createCommand()
                    ->update('ams_user', $data, 'id=:id', array(':id' => $lo_staff_image_info->user_id)
            );
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getUpcomingAvailableShifts($lo_staff_info) {

        $la_job_id = Utility::getAvailableJobTypeForStaff($lo_staff_info->staff_id);
        $ls_job_id = implode(",", $la_job_id);

        $ls_ordey_by = "order by staff_request_id desc";
        if (isset($lo_staff_info->filter_hospital) && $lo_staff_info->filter_hospital != '' && isset($lo_staff_info->filter_date) && $lo_staff_info->filter_date != '') {
            $sqlQuery = "SELECT s.* FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h WHERE s.shift_start_datetime LIKE '" . $lo_staff_info->filter_date . "%' AND s.hospital_unit_id = h.hospital_unit_id AND h.hospital_unit = '" . $lo_staff_info->filter_hospital . "' AND s.job_type_id IN (" . $ls_job_id . ")";
        } elseif (isset($lo_staff_info->filter_hospital) && $lo_staff_info->filter_hospital != '') {
            $sqlQuery = "SELECT s.* FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h WHERE s.hospital_unit_id = h.hospital_unit_id AND h.hospital_unit = '" . $lo_staff_info->filter_hospital . "' AND s.job_type_id IN (" . $ls_job_id . ")";
        } elseif (isset($lo_staff_info->filter_date) && $lo_staff_info->filter_date != '') {
            $sqlQuery .= "SELECT s.* FROM {{shift_management_for_hospital}} s WHERE s.shift_start_datetime LIKE '" . $lo_staff_info->filter_date . "%' AND s.job_type_id IN (" . $ls_job_id . ")";
        } else {
            $sqlQuery = "SELECT s.* FROM {{shift_management_for_hospital}} s WHERE s.job_type_id IN (" . $ls_job_id . ")";
        }
        $sqlQuery .= $ls_ordey_by;

        $la_availableShiftDetails = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $la_staff_request_id = Utility::getAvailableDateTimeForStaffForApp($lo_staff_info);
        $la_resultAvailableShiftDetails = array();
        $i = 0;
        foreach ($la_availableShiftDetails as $shiftDetails) {
            if (in_array($shiftDetails['staff_request_id'], $la_staff_request_id)) {
                $la_resultAvailableShiftDetails[$i++] = $shiftDetails;
            }
        }
        $la_resultArray = array();
        $i = 0;
        foreach ($la_resultAvailableShiftDetails as $value) {

            $sqlQuery = "SELECT job_type, hospital_unit, ward_name  FROM {{job_type}} j, {{hospital_unit}} h, {{ward}} w WHERE j.job_type_id='" . $value['job_type_id'] . "' AND h.hospital_unit_id = '" . $value['hospital_unit_id'] . "' AND w.ward_id = '" . $value['ward_id'] . "' ";
            $la_data = Yii::app()->db->createCommand($sqlQuery)->queryRow();
            $la_resultArray[$i] = $value;
            $li_response = Utility::checkApplyStatus($la_resultArray[$i]['staff_request_id'], $lo_staff_info->user_id);
            if ($li_response) {
                $la_resultArray[$i]['apply_status'] = false;
            } else {
                $la_resultArray[$i]['apply_status'] = true;
            }
            $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
            $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);

            $la_shift_start = explode(" ", $la_resultArray[$i]['shift_start_datetime']);
            $la_resultArray[$i]['shift_date'] = $la_shift_start[0];
            $la_shift_end = explode(" ", $la_resultArray[$i]['shift_end_datetime']);
            $la_resultArray[$i]['shift_time_start'] = $la_shift_start[1];
            $la_resultArray[$i]['shift_time_end'] = $la_shift_end[1];

            $la_resultArray[$i]['job_type_id'] = $la_data['job_type'];
            $la_resultArray[$i]['hospital_unit_id'] = $la_data['hospital_unit'];
            $la_resultArray[$i++]['ward_id'] = $la_data['ward_name'];
        }
        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getUpcomingAvailableShiftDetails($li_request_id) {
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $li_request_id . " AND `status` = 'A'";
        $la_availableShiftDetails = Yii::app()->db->createCommand($sqlQuery)->queryRow();
        $sqlQuery = "SELECT j.job_type, h.hospital_unit, h.address, w.ward_name  FROM {{job_type}} j, {{hospital_unit}} h, {{ward}} w WHERE j.job_type_id='" . $la_availableShiftDetails['job_type_id'] . "' AND h.hospital_unit_id = '" . $la_availableShiftDetails['hospital_unit_id'] . "' AND w.ward_id = '" . $la_availableShiftDetails['ward_id'] . "' ";
        $la_data = Yii::app()->db->createCommand($sqlQuery)->queryRow();
        $la_availableShiftDetails['shift_start_datetime'] = Utility::changeDateToUK($la_availableShiftDetails['shift_start_datetime']);
        $la_availableShiftDetails['shift_end_datetime'] = Utility::changeDateToUK($la_availableShiftDetails['shift_end_datetime']);
        $la_availableShiftDetails['job_type_id'] = $la_data['job_type'];
        $la_availableShiftDetails['hospital_unit_id'] = $la_data['hospital_unit'];
        $la_availableShiftDetails['ward_id'] = $la_data['ward_name'];
        $la_availableShiftDetails['hospital_address'] = $la_data['address'];
        return $la_availableShiftDetails;
    }

    public function shiftApply($lo_shift_info) {
//        echo $li_qry_res;die;
//        $modelQnquiry = new ShiftEnquiry;
//        $modelQnquiry->staff_request_id = $lo_shift_info->staff_request_id;
//        $modelQnquiry->staff_id = $lo_shift_info->user_id;
//        $modelQnquiry->enquired_by = $lo_shift_info->user_id;
//        $modelQnquiry->availability_confirmed_by_staff = 'Y';
//        $modelQnquiry->availability_confirmed_via = 'Dashboard';
//        $modelQnquiry->confirmed_by = 'S';
//        $modelQnquiry->agent_user_id = 0;
//        $modelQnquiry->is_confirmed = 'N';
        $sqlQuery = "INSERT INTO {{shift_enquiry_ack}} SET "
                . "`staff_request_id`='" . $lo_shift_info->staff_request_id . "',
                   `staff_id`='" . $lo_shift_info->user_id . "',
                   `enquired_by`='" . $lo_shift_info->user_id . "',
                   `availability_confirmed_by_staff`= 'Y',
                   `availability_confirmed_via`= 'Dashboard',
                   `confirmed_by`= 'S',
                   `agent_user_id`= 0,
                   `is_confirmed`= 'N'";
        $li_qry_res = Yii::app()->db->createCommand($sqlQuery)->execute();
        if ($li_qry_res) {
            return true;
        } else {
            return false;
        }
    }

    public function shiftCancel($lo_shift_info) {

        $li_qry_res = Yii::app()->db->createCommand()->delete('ams_shift_enquiry_ack', 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $lo_shift_info->user_id, ':staff_request_id' => $lo_shift_info->staff_request_id));
        if ($li_qry_res) {
            return true;
        } else {
            return false;
        }
    }

    public function getPreBookedShifts($lo_staff_info) {

        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT {{shift_management_for_hospital}}.* FROM {{booking}}, {{shift_management_for_hospital}} WHERE {{booking}}.staff_request_id = {{shift_management_for_hospital}}.staff_request_id AND {{booking}}.cancel_by_whom = 0 AND {{booking}}.staff_id = " . $lo_staff_info->user_id . " AND {{shift_management_for_hospital}}.shift_start_datetime > '" . $date . "'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($la_qry_res) {
            $i = 0;
            foreach ($la_qry_res as $value) {
                $sqlQuery = "SELECT first_name,job_type, hospital_unit, ward_name  FROM {{job_type}} j, {{hospital_unit}} h, {{ward}} w, {{user}} u WHERE j.job_type_id='" . $value['job_type_id'] . "' AND h.hospital_unit_id = '" . $value['hospital_unit_id'] . "' AND w.ward_id = '" . $value['ward_id'] . "' AND u.id = '" . $lo_staff_info->user_id . "'";
                $la_data = Yii::app()->db->createCommand($sqlQuery)->queryRow();
                $la_resultArray[$i] = $value;

//            $sqlQuery = "SELECT first_name FROM {{user}} WHERE `id` = " . $lo_staff_info->user_id;
//            $ls_staff_name = Yii::app()->db->createCommand($sqlQuery)->queryRow();
//            $la_resultArray[$i]['staff_name'] = $ls_staff_name->first_name;

                $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);

                $la_shift_start = explode(" ", $la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_date'] = $la_shift_start[0];
                $la_shift_end = explode(" ", $la_resultArray[$i]['shift_end_datetime']);
                $la_resultArray[$i]['shift_time_start'] = $la_shift_start[1];
                $la_resultArray[$i]['shift_time_end'] = $la_shift_end[1];

                $la_resultArray[$i]['staff_name'] = $la_data['first_name'];
                $la_resultArray[$i]['job_type_id'] = $la_data['job_type'];
                $la_resultArray[$i]['hospital_unit_id'] = $la_data['hospital_unit'];
                $la_resultArray[$i++]['ward_id'] = $la_data['ward_name'];
            }
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getHistoricalShifts($lo_staff_info) {

        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT {{shift_management_for_hospital}}.* FROM {{booking}}, {{shift_management_for_hospital}} WHERE {{booking}}.staff_request_id = {{shift_management_for_hospital}}.staff_request_id AND {{booking}}.cancel_by_whom = 0 AND {{booking}}.staff_id = " . $lo_staff_info->user_id . " AND {{shift_management_for_hospital}}.shift_start_datetime < '" . $date . "'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($la_qry_res) {
            $i = 0;
            foreach ($la_qry_res as $value) {
                $sqlQuery = "SELECT first_name,job_type, hospital_unit, ward_name  FROM {{job_type}} j, {{hospital_unit}} h, {{ward}} w, {{user}} u WHERE j.job_type_id='" . $value['job_type_id'] . "' AND h.hospital_unit_id = '" . $value['hospital_unit_id'] . "' AND w.ward_id = '" . $value['ward_id'] . "' AND u.id = '" . $lo_staff_info->user_id . "'";
                $la_data = Yii::app()->db->createCommand($sqlQuery)->queryRow();
                $la_resultArray[$i] = $value;

                $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);

                $la_shift_start = explode(" ", $la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_date'] = $la_shift_start[0];
                $la_shift_end = explode(" ", $la_resultArray[$i]['shift_end_datetime']);
                $la_resultArray[$i]['shift_time_start'] = $la_shift_start[1];
                $la_resultArray[$i]['shift_time_end'] = $la_shift_end[1];

                $la_resultArray[$i]['staff_name'] = $la_data['first_name'];
                $la_resultArray[$i]['job_type_id'] = $la_data['job_type'];
                $la_resultArray[$i]['hospital_unit_id'] = $la_data['hospital_unit'];
                $la_resultArray[$i++]['ward_id'] = $la_data['ward_name'];
            }
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getCancelConfirmedShifts($lo_staff_info) {

        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT {{shift_management_for_hospital}}.* FROM {{booking}}, {{shift_management_for_hospital}} WHERE {{booking}}.staff_request_id = {{shift_management_for_hospital}}.staff_request_id AND {{booking}}.cancel_by_whom != 0 AND {{booking}}.staff_id = " . $lo_staff_info->user_id;
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($la_qry_res) {
            $i = 0;
            foreach ($la_qry_res as $value) {
                $sqlQuery = "SELECT first_name,job_type, hospital_unit, ward_name  FROM {{job_type}} j, {{hospital_unit}} h, {{ward}} w, {{user}} u WHERE j.job_type_id='" . $value['job_type_id'] . "' AND h.hospital_unit_id = '" . $value['hospital_unit_id'] . "' AND w.ward_id = '" . $value['ward_id'] . "' AND u.id = '" . $lo_staff_info->user_id . "'";
                $la_data = Yii::app()->db->createCommand($sqlQuery)->queryRow();
                $la_resultArray[$i] = $value;

                $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);

                $la_shift_start = explode(" ", $la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_date'] = $la_shift_start[0];
                $la_shift_end = explode(" ", $la_resultArray[$i]['shift_end_datetime']);
                $la_resultArray[$i]['shift_time_start'] = $la_shift_start[1];
                $la_resultArray[$i]['shift_time_end'] = $la_shift_end[1];

                $la_resultArray[$i]['staff_name'] = $la_data['first_name'];
                $la_resultArray[$i]['job_type_id'] = $la_data['job_type'];
                $la_resultArray[$i]['hospital_unit_id'] = $la_data['hospital_unit'];
                $la_resultArray[$i++]['ward_id'] = $la_data['ward_name'];
            }
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getHospitalNames($ls_input_text) {

        $sqlQuery = "SELECT DISTINCT ( `hospital_unit` ) as `hospitals` FROM  {{hospital_unit}}
                WHERE  `hospital_unit` LIKE  '$ls_input_text%' AND hospital_unit_active_status='Y'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryColumn();
        if ($la_qry_res) {
            return $la_qry_res;
        } else {
            return 0;
        }
    }

    public function uploadTimesheetOfStaff($lo_timesheet_info) {

        $current_date_time = date('Y-m-d H:i');
        $sqlQuery = "INSERT INTO {{uploaded_timesheet_by_staff}} SET "
                . "`staff_id`='" . $lo_timesheet_info->user_id . "',
                   `ip`= '" . $lo_timesheet_info->ip . "',
                   `week_end_date`= '" . $lo_timesheet_info->week_end_date . "',
                   `upload_date_time`= '" . $current_date_time . "',
                   `timesheet_name`= '" . $lo_timesheet_info->timesheet_name . "'";
        $li_qry_res = Yii::app()->db->createCommand($sqlQuery)->execute();
        if ($li_qry_res) {
            return true;
        } else {
            return false;
        }
    }

    public function sendEmail($lo_timesheet_info) {
        $sqlQuery = "SELECT first_name,email FROM {{user}} WHERE `id`='" . $lo_timesheet_info->user_id . "' ";
        $la_staff_details = Yii::app()->db->createCommand($sqlQuery)->queryRow();

        $la_staffStatus = YII::app()->params['timesheetEmail'];
        $to = $la_staffStatus['email'];
        $subject = 'Timesheet from ' . $la_staff_details['first_name'] . ' for ';
        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: <" . $la_staff_details['email'] . ">" . "\r\n";
        $message = '<p><h2>Hi,</h2></p><p>' . $la_staff_details['first_name'] . ' has sent <span>the following timesheets given below : </span></p>';

        $k = 0;
        foreach ($lo_timesheet_info->maildata as $value) {
            if ($k == 0) {
                $k++;
                $subject .= $value->week_end_date;
            } else {
                $k++;
                $subject .= ', ' . $value->week_end_date . " ";
            }
            $url = Yii::app()->getBaseUrl(true) . "/staffTimesheet/" . $value->timesheet_name;
            $message .= '<table cellspacing="0" cellpadding="0"> <tr>';
            $message .= '<td align="center" width="300" height="40" bgcolor="#4f27d2" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">';
            $message .= '<a href="' . $url . '" style="color: #ffffff; font-size:16px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">Download ' . $value->week_end_date . ' timesheet!</a>';
            $message .= '</td> </tr> </table>';
            $message .= '<br>';
        }
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    /*     * *************COORDINATOR SECTION**************** */
    /*     * ************************************************ */

    public function getCoordinatorDetails($lo_user) {
//        print_r($lo_user->user_id);die;
        $sqlQuery = "SELECT first_name,last_name FROM {{user}} WHERE `id`='" . $lo_user->user_id . "' ";
        $la_coordinatorName = Yii::app()->db->createCommand($sqlQuery)->queryRow();
        $ld_today = date("Y-m-d");
        $ld_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 7 day"));
//        $command = Yii::app()->db->createCommand("SELECT `shift_start_datetime`, `request_accepted_by`, SUM(`quantity`), SUM(`quantity_confirmed`) FROM {{shift_management_for_hospital}} WHERE `request_accepted_by` = " . $_SESSION['logged_user']['id'] . " AND `shift_start_datetime` BETWEEN '" . $ld_today . "' AND '" . $ld_dateThreshold . "' GROUP BY `request_accepted_by`, `shift_start_datetime` ")->queryAll();
        $command = Yii::app()->db->createCommand("SELECT `shift_start_datetime`, `request_accepted_by`, `quantity`, `quantity_confirmed` FROM {{shift_management_for_hospital}} WHERE `request_accepted_by` = " . $lo_user->user_id . " AND `shift_start_datetime` BETWEEN '" . $ld_today . "' AND '" . $ld_dateThreshold . "'")->queryAll();
        $i = 0;
        foreach ($command AS $la_value) {
            $command1[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_value['shift_start_datetime']);
            $command1[$i++]['percentage'] = round(($la_value['quantity_confirmed'] / $la_value['quantity']) * 100, 2);
        }
        if ($command) {
            $la_coordinator['chart_data'] = $command1;
            $la_coordinator['first_name'] = $la_coordinatorName['first_name'];
            $la_coordinator['last_name'] = $la_coordinatorName['last_name'];
            $la_coordinator['no_shift'] = 'false';
            return $la_coordinator;
        } elseif ($la_coordinatorName) {
            $la_coordinatorName['no_shift'] = 'true';
            return $la_coordinatorName;
        } else {
            return 'fail';
        }
    }

    public function getAllHospitalLists() {
        $sqlQuery = "SELECT hu.*, hr.hospital_name as hospital_group, w.area_name as area_name, u.email as relevant_coordinator FROM {{hospital_unit}} hu, {{hospital_registration}} hr, {{work_area}} w, {{user}} u WHERE hu.relevant_coordinator_id = u.id AND hu.local_area_id = w.work_area_id AND hu.hospital_id = hr.hospital_id AND hu.hospital_unit_active_status = 'Y'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($la_qry_res) {
            return $la_qry_res;
        } else {
            return 'no data';
        }
    }

    public function getAllStaffLists() {
//        $sqlQuery = "SELECT hu.*, hr.hospital_name as hospital_group, w.area_name as area_name, u.email as relevant_coordinator FROM {{hospital_unit}} hu, {{hospital_registration}} hr, {{work_area}} w, {{user}} u WHERE hu.relevant_coordinator_id = u.id AND hu.local_area_id = w.work_area_id AND hu.hospital_id = hr.hospital_id AND hu.hospital_unit_active_status = 'Y'" ;
//        $sqlQuery = "SELECT s.*, pwa.work_area_id FROM {{staff_registration}} s, {{staff_registration_preferred_work_area_map_table}} pwa WHERE s.staff_id = pwa.staff_id AND s.staff_status = 'A' group by s.staff_id";
        $sqlQuery = "SELECT * FROM {{staff_registration}}  WHERE staff_status = 'A'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($la_qry_res);die;
        $i = 0;
        foreach ($la_qry_res AS $la_value) {
            $la_resultArray[$i] = $la_value;
            $ls_work_area = Utility::getAreaForStaff($la_value[staff_id]);
            $la_resultArray[$i++]['preferred_work_area'] = $ls_work_area;
        }
        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function sendMailOrSmsToAllstaff($la_mailInfo) {
        Yii::import('application.modules.admin.controllers.StaffRegistrationController');
        StaffRegistrationController::actionSendAllSMSOrMail($la_mailInfo->mailSting);
    }

    public function sendMailOrSms($la_staffInfo) {
//         print_r($la_staffInfo);die;
        Yii::import('application.modules.admin.controllers.StaffRegistrationController');
        StaffRegistrationController::actionSendSMSOrMail($la_staffInfo->id, $la_staffInfo->email, $la_staffInfo->mobile);
    }

    public function getAllDraftStaffLists() {
//        $sqlQuery = "SELECT hu.*, hr.hospital_name as hospital_group, w.area_name as area_name, u.email as relevant_coordinator FROM {{hospital_unit}} hu, {{hospital_registration}} hr, {{work_area}} w, {{user}} u WHERE hu.relevant_coordinator_id = u.id AND hu.local_area_id = w.work_area_id AND hu.hospital_id = hr.hospital_id AND hu.hospital_unit_active_status = 'Y'" ;
//        $sqlQuery = "SELECT s.*, pwa.work_area_id FROM {{staff_registration}} s, {{staff_registration_preferred_work_area_map_table}} pwa WHERE s.staff_id = pwa.staff_id AND s.staff_status = 'A' group by s.staff_id";
        $sqlQuery = "SELECT * FROM {{staff_registration}}  WHERE staff_status = 'D'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($la_qry_res);die;
        $i = 0;
        foreach ($la_qry_res AS $la_value) {
            $la_resultArray[$i] = $la_value;
            $ls_work_area = Utility::getAreaForStaff($la_value[staff_id]);
            $la_resultArray[$i++]['preferred_work_area'] = $ls_work_area;
        }
        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getAllInactiveStaffLists() {
//        $sqlQuery = "SELECT hu.*, hr.hospital_name as hospital_group, w.area_name as area_name, u.email as relevant_coordinator FROM {{hospital_unit}} hu, {{hospital_registration}} hr, {{work_area}} w, {{user}} u WHERE hu.relevant_coordinator_id = u.id AND hu.local_area_id = w.work_area_id AND hu.hospital_id = hr.hospital_id AND hu.hospital_unit_active_status = 'Y'" ;
//        $sqlQuery = "SELECT s.*, pwa.work_area_id FROM {{staff_registration}} s, {{staff_registration_preferred_work_area_map_table}} pwa WHERE s.staff_id = pwa.staff_id AND s.staff_status = 'A' group by s.staff_id";
        $sqlQuery = "SELECT * FROM {{staff_registration}}  WHERE staff_status = 'I'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($la_qry_res);die;
        $i = 0;
        foreach ($la_qry_res AS $la_value) {
            $la_resultArray[$i] = $la_value;
            $ls_work_area = Utility::getAreaForStaff($la_value[staff_id]);
            $la_resultArray[$i++]['preferred_work_area'] = $ls_work_area;
        }
        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getAllSuspendedStaffLists() {
//        $sqlQuery = "SELECT hu.*, hr.hospital_name as hospital_group, w.area_name as area_name, u.email as relevant_coordinator FROM {{hospital_unit}} hu, {{hospital_registration}} hr, {{work_area}} w, {{user}} u WHERE hu.relevant_coordinator_id = u.id AND hu.local_area_id = w.work_area_id AND hu.hospital_id = hr.hospital_id AND hu.hospital_unit_active_status = 'Y'" ;
//        $sqlQuery = "SELECT s.*, pwa.work_area_id FROM {{staff_registration}} s, {{staff_registration_preferred_work_area_map_table}} pwa WHERE s.staff_id = pwa.staff_id AND s.staff_status = 'A' group by s.staff_id";
        $sqlQuery = "SELECT * FROM {{staff_registration}}  WHERE staff_status = 'S'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($la_qry_res);die;
        $i = 0;
        foreach ($la_qry_res AS $la_value) {
            $la_resultArray[$i] = $la_value;
            $ls_work_area = Utility::getAreaForStaff($la_value[staff_id]);
            $la_resultArray[$i++]['preferred_work_area'] = $ls_work_area;
        }
        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getAllArchiveStaffLists() {
//        $sqlQuery = "SELECT hu.*, hr.hospital_name as hospital_group, w.area_name as area_name, u.email as relevant_coordinator FROM {{hospital_unit}} hu, {{hospital_registration}} hr, {{work_area}} w, {{user}} u WHERE hu.relevant_coordinator_id = u.id AND hu.local_area_id = w.work_area_id AND hu.hospital_id = hr.hospital_id AND hu.hospital_unit_active_status = 'Y'" ;
//        $sqlQuery = "SELECT s.*, pwa.work_area_id FROM {{staff_registration}} s, {{staff_registration_preferred_work_area_map_table}} pwa WHERE s.staff_id = pwa.staff_id AND s.staff_status = 'A' group by s.staff_id";
        $sqlQuery = "SELECT * FROM {{staff_registration}}  WHERE staff_status = 'Ar'";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($la_qry_res);die;
        $i = 0;
        foreach ($la_qry_res AS $la_value) {
            $la_resultArray[$i] = $la_value;
            $ls_work_area = Utility::getAreaForStaff($la_value[staff_id]);
            $la_resultArray[$i++]['preferred_work_area'] = $ls_work_area;
        }
        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getautocompleteNameEmail($searchTerm) {
//         print_r($searchTerm);die;
        $sqlQueryForUser = "SELECT * FROM {{user}} u, {{staff_registration}} s WHERE s.staff_id = u.staff_id AND s.staff_status = 'A' AND u.type = 'S' AND (u.email LIKE '%" . $searchTerm . "%' OR u.first_name LIKE '%" . $searchTerm . "%' OR u.last_name LIKE '%" . $searchTerm . "%') ORDER BY u.email";
        $commandForUser = Yii::app()->db->createCommand($sqlQueryForUser)->queryAll();

        $data = array();
        foreach ($commandForUser AS $lo_user) {
            $value = $lo_user['first_name'] . " " . $lo_user['last_name'] . " (" . $lo_user['email'] . ")";
            $data[] = $value;
        }
        $list = $data;
        return $list;
    }

    public function getRotaDetailsOfStaffs($staffInfo) {
        $ld_today = date("Y-m-d");
        $ld_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 30 day"));

        $userEmail = $staffInfo->staffInfo;
        $startValue = strrpos($userEmail, "(") + 1;

        $ls_email = substr($userEmail, $startValue, -1);

        $startDate = $ld_today;
        $endDate = $ld_dateThreshold;
        $sqlQuery = "SELECT u.first_name, u.last_name, u.email, h.hospital_unit, j.job_type, w.ward_name, s.shift_start_datetime, s.shift_end_datetime FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b, {{ward}} w WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND s.ward_id = w.ward_id AND b.staff_id = u.id AND b.cancel_by_whom = '0' AND u.email = '" . $ls_email . "' AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY s.shift_start_datetime";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if (count($command) == 0) {
            return 'no data';
        } else {
            return $command;
        }
    }

    public function getExpiryReportDetails($expiryInfo) {

//       $expiryInfo->category = $getData['category'];
//       $expiryInfo->start_date = $getData['start_date'];
//       $expiryInfo->end_date = $getData['end_date'];
       //print_r($expiryInfo); die;
 
        $la_staffStatus = YII::app()->params['staffStatus'];
        if ($expiryInfo->category == "DBS_expiry") {
            if ($expiryInfo->start_date != "") {
                $startDate = Utility::changeDateToMysql($expiryInfo->start_date);
            }
            if ($expiryInfo->end_date != "") {
                $endDate = Utility::changeDateToMysql($expiryInfo->start_date);
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
            return $outputArray;
//            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($expiryInfo->category == "Visa_expiry") {
            if ($expiryInfo->start_date != "") {
                $startDate = Utility::changeDateToMysql($expiryInfo->start_date);
            }
            if ($expiryInfo->end_date != "") {
                $endDate = Utility::changeDateToMysql($expiryInfo->end_date);
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
            return $outputArray;
//            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($expiryInfo->category == "Passport_expiry") {
            if ($expiryInfo->start_date != "") {
                $startDate = Utility::changeDateToMysql($expiryInfo->start_date);
            }
            if ($expiryInfo->end_date != "") {
                $endDate = Utility::changeDateToMysql($expiryInfo->end_date);
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
            return $outputArray;
//            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($expiryInfo->category == "Mandatory_training_expiry") {
            if ($expiryInfo->start_date != "") {
                $startDate = Utility::changeDateToMysql($expiryInfo->start_date);
            }
            if ($expiryInfo->end_date != "") {
                $endDate = Utility::changeDateToMysql($expiryInfo->end_date);
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
            return $outputArray;
//            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($expiryInfo->category == "Pmva_expiry") {
            if ($expiryInfo->start_date != "") {
                $startDate = Utility::changeDateToMysql($expiryInfo->start_date);
            }
            if ($expiryInfo->end_date != "") {
                $endDate = Utility::changeDateToMysql($expiryInfo->end_date);
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
            return $outputArray;
//            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($expiryInfo->category == "Maybo_expiry") {
            if ($expiryInfo->start_date != "") {
                $startDate = Utility::changeDateToMysql($expiryInfo->start_date);
            }
            if ($expiryInfo->end_date != "") {
                $endDate = Utility::changeDateToMysql($expiryInfo->end_date);
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
            return $outputArray;
//            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        } else if ($expiryInfo->category == "Pin_expiry") {
            if ($expiryInfo->start_date != "") {
                $startDate = Utility::changeDateToMysql($expiryInfo->start_date);
            }
            if ($expiryInfo->end_date != "") {
                $endDate = Utility::changeDateToMysql($expiryInfo->end_date);
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
            return $outputArray;
//            Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
        }
//        $this->render('reports');
    }

    public function getShiftAllocationReportDetails($shiftAllocationInfo) {
        if ($shiftAllocationInfo->start_date != "") {
            $startDate = Utility::changeDateToMysql($shiftAllocationInfo->start_date);
        }
        if ($shiftAllocationInfo->end_date != "") {
            $endDate = Utility::changeDateToMysql($shiftAllocationInfo->end_date);
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
        return $outputArray;
//        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
            exit();
//        $this->render('reports');
        }

    public function getAllStaffList() {
        $command = Yii::app()->db->createCommand("SELECT SR.*,CONCAT(`first_name`,' ', `last_name`) as `full_name` FROM {{staff_registration}} SR ORDER BY full_name")->queryAll();
        $la_staff = array();
        $la_temp = array();
        $key = 0;
        foreach ($command as $lo_user) {
            $la_temp['id'] = $lo_user['staff_id'];
            $la_temp['value'] = $lo_user['full_name'] . '(' . $lo_user['email'] . ')';
            $la_staff[$key++] = $la_temp;
        }
//       print_r($la_hos);
//        die();
        return $la_staff;
    }

    public function getStaffAvailabilityDetails($staffAvailabilityInfo) {

        $la_post = array();
        $la_result = array();
        $la_post['startDate'] = $staffAvailabilityInfo->start_date;
        $la_post['endDate'] = $staffAvailabilityInfo->end_date;
        $la_post['startTime'] = $staffAvailabilityInfo->start_time;
        $la_post['endTime'] = $staffAvailabilityInfo->end_time;
        $la_post['staff'] = $staffAvailabilityInfo->id;
//        print_r($la_post);die;
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
                    $lv_workArea .= ", ";
                $lv_workArea .= $rec1['area_name'];
            }

            $sqlQuery1 = "SELECT `job_type` FROM {{job_type}} j, {{staff_job_type_map}} s WHERE j.job_type_id = s.job_type_id AND s.staff_id = " . $rec['staff_id'];
            $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
            foreach ($command1 as $rec2) {
                if ($lv_jobType != "")
                    $lv_jobType .= ", ";
                $lv_jobType .= $rec2['job_type'];
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
        return $outputArray;
//        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
//        $this->render('reports');
    }

    public function getStaffCancelDetails($staffCancelInfo) {
        if ($staffCancelInfo->start_date != "") {
            $startDate = Utility::changeDateToMysql($staffCancelInfo->start_date);
        }
        if ($staffCancelInfo->end_date != "") {
            $endDate = Utility::changeDateToMysql($staffCancelInfo->end_date);
        }
        $sqlQuery = "SELECT u.first_name, u.last_name, u.email, u.mobile, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime, b.cancellation_date, b.cancellation_time, b.cancel_by_whom, b.cancel_requested_by FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} r WHERE r.staff_id = u.staff_id AND b.staff_id = u.id AND b.staff_request_id = s.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND b.cancel_requested_by != '' AND r.staff_id =" . $staffCancelInfo->id;
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
        return $outputArray;
//        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
//        $this->render('reports');
    }

    public function getNotAllocatedStaffDetails($notAllocatedStaffInfo) {
        if ($notAllocatedStaffInfo->start_date != "") {
            $startDate = Utility::changeDateToMysql($notAllocatedStaffInfo->start_date);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($notAllocatedStaffInfo->end_date != "") {
            $endDate = Utility::changeDateToMysql($notAllocatedStaffInfo->end_date);
            $object = new DateTime($endDate);
            $object->setTime(23, 59, 59);
            $endDate = $object->format('Y-m-d H:i:s');
        }

        $sqlQuery = "SELECT h.hospital_unit, w.ward_name, j.job_type, s.shift_start_datetime, s.shift_end_datetime FROM {{shift_management_for_hospital}} s, {{shift_enquiry_ack}} e, {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE s.staff_request_id = e.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND s.ward_id = w.ward_id AND e.confirmed_by = 'S' AND e.is_confirmed = 'N' AND u.staff_id = " . $notAllocatedStaffInfo->id . " AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
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
        return $outputArray;
//        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
//        $this->render('reports');
    }
    
    public function getRotaReportDetails($rotaInfo) {
        if ($rotaInfo->start_date != "") {
            $startDate = Utility::changeDateToMysql($rotaInfo->start_date);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($rotaInfo->end_date != "") {
            $endDate = Utility::changeDateToMysql($rotaInfo->end_date);
            $object = new DateTime($endDate);
            $object->setTime(23, 59, 59);
            $endDate = $object->format('Y-m-d H:i:s');
        }

        $sqlQuery = "SELECT s.requested_date, s.requested_time, s.requested_person, s.requested_person_mobile_number, h.hospital_unit, j.job_type, s.shift_start_datetime, s.shift_end_datetime, u.first_name, u.last_name, u.mobile, b.confirmation_date, b.confirmation_time, b.confirm_by_whom, b.cancellation_date, b.cancellation_time, b.cancel_by_whom, b.cancel_requested_by FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND b.staff_id = u.id AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND h.hospital_unit_id IN (";
        $count = count($rotaInfo->id);
        $lvHospitalId = '';
        for ($i = 0; $i < $count; $i++) {
            if ($i != 0)
                $lvHospitalId .= ',';
            $lvHospitalId .= $rotaInfo->id[$i];
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
        return $outputArray;
//        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
//        $this->render('reports');
    }

    public function getHospitalServiceInfoDetails($hospitalServiceInfo) {
        if ($hospitalServiceInfo->start_date != "") {
            $startDate = Utility::changeDateToMysql($hospitalServiceInfo->start_date);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($hospitalServiceInfo->end_date != "") {
            $endDate = Utility::changeDateToMysql($hospitalServiceInfo->end_date);
            $object = new DateTime($endDate);
            $object->setTime(23, 59, 59);
            $endDate = $object->format('Y-m-d H:i:s');
        }

        $sqlQuery = "SELECT h.hospital_unit, u.first_name, u.last_name, j.job_type, s.shift_start_datetime, s.shift_end_datetime FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND b.staff_id = u.id AND b.cancel_by_whom = '0' AND s.hospital_unit_id = " . $hospitalServiceInfo->id . " AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $sqlQueryTypeCount = "SELECT COUNT(j.job_type_id), j.job_type FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{job_type}} j, {{user}} u, {{booking}} b WHERE s.staff_request_id = b.staff_request_id AND s.hospital_unit_id = h.hospital_unit_id AND s.job_type_id = j.job_type_id AND b.staff_id = u.id AND b.cancel_by_whom = '0' AND s.hospital_unit_id = " . $hospitalServiceInfo->id . " AND s.shift_start_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'GROUP BY j.job_type";
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
        return $outputArray;
//        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
//        $this->render('reports');
    }

    public function getStaffRotaReportDetails($StaffInfo) {
        $userEmail = $StaffInfo->staffInfo;
        $startValue = strrpos($userEmail, "(") + 1;

        $ls_email = substr($userEmail, $startValue, -1);

        if ($StaffInfo->start_date != "") {
            $startDate = Utility::changeDateToMysql($StaffInfo->start_date);
            $object = new DateTime($startDate);
            $object->setTime(00, 00, 00);
            $startDate = $object->format('Y-m-d H:i:s');
        }

        if ($StaffInfo->end_date != "") {
            $endDate = Utility::changeDateToMysql($StaffInfo->end_date);
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
        return $outputArray;
//        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('reports');
    }

    public function getAllHospitalNameList() {
        $la_allHospitalUnits = CHtml::listData(HospitalUnit::model()->findAll('hospital_unit_active_status="Y"'), 'hospital_unit_id', 'hospital_unit');
        print_r($la_allHospitalUnits);
        die;
    }

    public function getAllHospitalUnitNames() {
        $sqlQuery = "SELECT hospital_unit_id,hospital_unit FROM {{hospital_unit}} order by hospital_unit";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($la_qry_res) {
            return $la_qry_res;
        } else {
            return 'no data';
        }
    }

    public function getAlljobTypes() {
        $sqlQuery = "SELECT job_type_id,job_type FROM {{job_type}} order by job_type";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        if ($la_qry_res) {
            return $la_qry_res;
        } else {
            return 'no data';
        }
    }

    public function getHospitalWards($li_hospital_unit_id) {
        $sqlQuery = "SELECT contact_number FROM {{hospital_unit}} WHERE hospital_unit_id =" . $li_hospital_unit_id;
        $li_contact_number = Yii::app()->db->createCommand($sqlQuery)->queryRow();
        $sqlQuery = "SELECT w.ward_name,w_map.ward_id FROM {{ward_hospital_unit_map}} w_map,{{ward}} w WHERE w.ward_id =  w_map.ward_id AND w_map.hospital_unit_id =" . $li_hospital_unit_id;
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $la_qry_res['contact_number'] = $li_contact_number['contact_number'];
        if ($la_qry_res) {
            return $la_qry_res;
        } else {
            return 'no data';
        }
    }

    public function createShiftForHospitals($lo_shift_info) {
//        print_r($lo_shift_info);die;
        if (isset($lo_shift_info->notes) && $lo_shift_info->notes != '') {
            $ls_notes = Utility::formatInput($lo_shift_info->notes);
        } else {
            $ls_notes = "";
        }
        $la_req_date_time = explode(" ", $lo_shift_info->req_date_time);
        $sqlQuery = "INSERT INTO {{shift_management_for_hospital}} SET "
                . "`hospital_unit_id`='" . $lo_shift_info->hospital_unit . "',
                   `ward_id`= '" . $lo_shift_info->ward . "',
                   `job_type_id`= '" . $lo_shift_info->job_type . "',
                   `quantity`= " . $lo_shift_info->quantity . ",
                   `shift_start_datetime`= '" . $lo_shift_info->shift_start_date_time . "',
                   `shift_end_datetime`= '" . $lo_shift_info->shift_end_date_time . "',
                   `requested_date`= '" . $la_req_date_time[0] . "',
                   `requested_time`= '" . $la_req_date_time[1] . "',
                   `requested_person`= '" . $lo_shift_info->req_by . "',
                   `request_accepted_by`= '" . $lo_shift_info->user_id . "',
                   `requested_person_mobile_number`= '" . $lo_shift_info->req_per_mob . "',
                   `notes`= '" . $ls_notes . "'";
        $li_qry_res = Yii::app()->db->createCommand($sqlQuery)->execute();
        if ($li_qry_res) {
            return 'ok';
        } else {
            return 'fail';
        }
    }

    public function getAllShiftLists() {
        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT sm.*,hu.hospital_unit,j.job_type,u.email FROM {{shift_management_for_hospital}} sm, {{hospital_unit}} hu, {{user}} u, {{job_type}} j WHERE sm.hospital_unit_id = hu.hospital_unit_id AND sm.job_type_id = j.job_type_id AND sm.request_accepted_by = u.id AND sm.shift_start_datetime > '" . $date . "' AND sm.status = 'A' ORDER BY sm.staff_request_id DESC";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;
        foreach ($la_qry_res as $value) {
            $la_resultArray[$i] = $value;
            $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
            $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);
            $i++;
        }
        if ($la_qry_res) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getShiftDetailsForHospital($li_request_id) {
        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT sm.*, hu.hospital_unit, w.ward_name, j.job_type, u.first_name, u.last_name FROM {{shift_management_for_hospital}} sm, {{ward}} w, {{hospital_unit}} hu, {{user}} u, {{job_type}} j WHERE sm.hospital_unit_id = hu.hospital_unit_id AND sm.job_type_id = j.job_type_id AND sm.ward_id = w.ward_id AND sm.request_accepted_by = u.id AND sm.staff_request_id = " . $li_request_id;
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryRow();

        if ($la_qry_res['shift_start_datetime'] < $date) {
            $la_qry_res['date_over'] = "yes";
        } else {
            $la_qry_res['date_over'] = "no";
        }

        $la_qry_res['shift_start_datetime'] = Utility::changeDateToUK($la_qry_res['shift_start_datetime']);
        $la_qry_res['shift_end_datetime'] = Utility::changeDateToUK($la_qry_res['shift_end_datetime']);

        $la_qry_res['shift_start_datetime_sec'] = date(strtotime($la_qry_res['shift_start_datetime'])) * 1000;
        $la_qry_res['shift_end_datetime_sec'] = date(strtotime($la_qry_res['shift_end_datetime'])) * 1000;

        $la_qry_res['requested_date'] = Utility::changeDateToUK($la_qry_res['requested_date']);
        $la_qry_res['requested_datetime'] = $la_qry_res['requested_date'] . " " . $la_qry_res['requested_time'];

        if ($la_qry_res) {
            return $la_qry_res;
        } else {
            return 'no data';
        }
    }

    public function deleteShift($li_staff_request_id) {
        $sqlQuery = "DELETE FROM {{shift_management_for_hospital}} WHERE staff_request_id = " . $li_staff_request_id;
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->execute();
        if ($la_qry_res) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateShiftForHospitals($lo_shift_info) {

        if (isset($lo_shift_info->notes) && $lo_shift_info->notes != '') {
            $ls_notes = Utility::formatInput($lo_shift_info->notes);
        } else {
            $ls_notes = "";
        }

        if (isset($lo_shift_info->shift_start_datetime)) {
            $ls_shift_start_datetime = $lo_shift_info->shift_start_datetime;
        } else {
            $ls_shift_start_datetime = $lo_shift_info->shift_start_date_time;
        }

        if (isset($lo_shift_info->shift_end_datetime)) {
            $ls_shift_end_datetime = $lo_shift_info->shift_end_datetime;
        } else {
            $ls_shift_end_datetime = $lo_shift_info->shift_end_date_time;
        }

        $la_req_date_time = explode(" ", $lo_shift_info->req_date_time);

        $ls_shift_start_datetime = Utility::changeDateToMysql($ls_shift_start_datetime);
        $ls_shift_end_datetime = Utility::changeDateToMysql($ls_shift_end_datetime);
        $la_req_date_time[0] = Utility::changeDateToMysql($la_req_date_time[0]);

        $sqlQuery = "UPDATE {{shift_management_for_hospital}} SET "
                . "`hospital_unit_id`='" . $lo_shift_info->hospital_unit . "',
                   `ward_id`= '" . $lo_shift_info->ward . "',
                   `job_type_id`= '" . $lo_shift_info->job_type . "',
                   `quantity`= " . $lo_shift_info->quantity . ",
                   `shift_start_datetime`= '" . $ls_shift_start_datetime . "',
                   `shift_end_datetime`= '" . $ls_shift_end_datetime . "',
                   `requested_date`= '" . $la_req_date_time[0] . "',
                   `requested_time`= '" . $la_req_date_time[1] . "',
                   `requested_person`= '" . $lo_shift_info->req_by . "',
                   `request_accepted_by`= '" . $lo_shift_info->user_id . "',
                   `requested_person_mobile_number`= '" . $lo_shift_info->req_per_mob . "',
                   `status`= 'A',
                   `notes`= '" . $ls_notes . "' WHERE `staff_request_id` = " . $lo_shift_info->staff_request_id;

        $li_qry_res = Yii::app()->db->createCommand($sqlQuery)->execute();
        if ($li_qry_res) {
            return 'ok';
        } else {
            return 'fail';
        }
    }

    public function getAllShiftListsCreatedByYou($li_user_id) {

        $sqlQuery = "SELECT sm.*,hu.hospital_unit,j.job_type,u.email FROM {{shift_management_for_hospital}} sm, {{hospital_unit}} hu, {{user}} u, {{job_type}} j WHERE sm.hospital_unit_id = hu.hospital_unit_id AND sm.job_type_id = j.job_type_id AND sm.request_accepted_by = u.id AND sm.request_accepted_by = '" . $li_user_id . "' AND sm.status = 'A' ORDER BY sm.staff_request_id DESC";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;
        foreach ($la_qry_res as $value) {
            $la_resultArray[$i] = $value;
            $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
            $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);
            $i++;
        }
        if ($la_qry_res) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getStaffsWhomEnquiryNotSend($lo_info) {

        Yii::import('application.modules.admin.controllers.ShiftManagementForHospitalController');
        $staff = array();
        $staffs = array();
        $j = 0;
        $staffs = ShiftManagementForHospitalController::getAvailableStaffAll($lo_info->staffRequestId, Utility::changeDateToMysql($lo_info->shiftStartDatetime), Utility::changeDateToMysql($lo_info->shiftEndDatetime), $lo_info->jobTypeId, $lo_info->hospitalUnitId);

        foreach ($staffs as $record) {
            $sqlQueryForStaff = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $lo_info->staffRequestId . "' AND `staff_id` = " . $record[0];
            $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();
            if (count($commandForStaff) == 0) {
                $staff[$j] = $record;
                $staff[$j++]['user_id'] = $record[0];
            }
        }
        if ($staff) {
            return $staff;
        } else {
            return 'no data';
        }
    }

    public function sendEnquiry($lo_enquiry_info) {

        if (isset($lo_enquiry_info->staff)) {
            $data = array();
            $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $lo_enquiry_info->staff_request_id . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

            $sqlQueryAll = "SELECT `hospital_unit`, `mobile`, h.address, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE h.relevant_coordinator_id = u.id AND `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
            $commandAll = Yii::app()->db->createCommand($sqlQueryAll)->queryAll();

            $data['hospital_unit'] = $commandAll[0]['hospital_unit'];
            $data['address'] = $commandAll[0]['address'];
            $data['job_type'] = $commandAll[0]['job_type'];
            $data['ward_name'] = $commandAll[0]['ward_name'];
            $data['shift_start_datetime'] = Utility::changeDateToUK($command[0]['shift_start_datetime']) . " to " . Utility::changeTimeFromDateToUK($command[0]['shift_end_datetime']);

//            $post = $_POST;
//            $models = ShiftManagementForHospital::model()->find(array('condition' => 'staff_request_id=1'));
//            wDebug::debugObject($models->hospitalUnit->hospital_unit_id);
//            echo '-----------------------';
//            echo $models[0]['shift_start_datetime'];
//            $sqlQueryUser = "SELECT `email` FROM {{user}} WHERE `id` = '" . $post['staff_ids'][0] . "'";
//            $commandUser = Yii::app()->db->createCommand($sqlQueryUser)->queryAll();
//            echo $commandUser[0]['email'];

            for ($i = 0; $i < count($lo_enquiry_info->staff); $i++) {
                $modelAck = new ShiftEnquiryAck;
                $modelAck->staff_request_id = $lo_enquiry_info->staff_request_id;
                $modelAck->staff_id = $lo_enquiry_info->staff[$i];
                $modelAck->enquired_by = $lo_enquiry_info->user_id;
                $modelAck->confirmed_by = 'NA';
                $modelAck->agent_user_id = $lo_enquiry_info->user_id;
                $modelAck->save();

                $commandUser = Utility::getStaff($lo_enquiry_info->staff[$i]);

                Utility::sendEnquiryMailForApp($data, $commandUser[0]['first_name'], $commandUser[0]['email'], $commandUser[0]['mobile'], $commandAll[0]['mobile'], $lo_enquiry_info->user_email);
            }
            if (count($lo_enquiry_info->staff) == $i) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function directConfirmAvailability($lo_enquiry_info) {
        if (isset($lo_enquiry_info->staff)) {
            for ($i = 0; $i < count($lo_enquiry_info->staff); $i++) {
                $modelAck = new ShiftEnquiryAck;
                $modelAck->staff_request_id = $lo_enquiry_info->staff_request_id;
                $modelAck->staff_id = $lo_enquiry_info->staff[$i];
                $modelAck->enquired_by = $lo_enquiry_info->user_id;
                $modelAck->availability_confirmed_by_staff = 'Y';
                $modelAck->availability_confirmed_via = "By phone";
                $modelAck->confirmed_by = 'C';
                $modelAck->save();
            }
            if (count($lo_enquiry_info->staff) == $i) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function directConfirmBooking($lo_enquiry_info) {

        if (isset($lo_enquiry_info->staff)) {
            for ($i = 0; $i < count($lo_enquiry_info->staff); $i++) {
                $sqlQuery = "SELECT `shift_start_datetime`, `shift_end_datetime`, `quantity_confirmed`, `quantity` FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $lo_enquiry_info->staff_request_id;
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

                $count = $command[0]['quantity_confirmed'];
                if ($command[0]['quantity_confirmed'] == $command[0]['quantity']) {
                    return 'fulfilled';
                    break;
                }
                $modelAck = new ShiftEnquiryAck;
                $modelAck->staff_request_id = $lo_enquiry_info->staff_request_id;
                $modelAck->staff_id = $lo_enquiry_info->staff[$i];
                $modelAck->enquired_by = $lo_enquiry_info->user_id;
                $modelAck->availability_confirmed_by_staff = 'Y';
                $modelAck->availability_confirmed_via = "By phone";
                $modelAck->confirmed_by = 'C';
                $modelAck->agent_user_id = $lo_enquiry_info->user_id;
                $modelAck->is_confirmed = 'Y';
                $modelAck->save();


                $count = $count + 1;

                $lv_shiftStartDate = substr($command[0]['shift_start_datetime'], 0, 10);
                $lv_shiftStartTime = substr($command[0]['shift_start_datetime'], 11);

                $lv_shiftEndDate = substr($command[0]['shift_end_datetime'], 0, 10);
                $lv_shiftEndTime = substr($command[0]['shift_end_datetime'], 11);

                $data = array(
                    "quantity_confirmed" => $count
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $lo_enquiry_info->staff_request_id)
                );
                $modelBooking = new Booking;
                $modelBooking->staff_request_id = $lo_enquiry_info->staff_request_id;
                $modelBooking->staff_id = $lo_enquiry_info->staff[$i];
                $modelBooking->confirmation_date = date("Y-m-d");
                $modelBooking->confirmation_time = date("H:i:s");
                $modelBooking->confirm_by_whom = 'C';
                $modelBooking->cancel_by_whom = '0';
                $modelBooking->cancellation_date = "0000-00-00";
                $modelBooking->cancellation_time = "00:00:00";
                $modelBooking->cancel_requested_by = "";

                if ($modelBooking->save()) {

                    /*
                     * Start Confirmation Mail function
                     */
                    $data = array();
                    $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $lo_enquiry_info->staff_request_id . "'";
                    $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

                    $sqlQueryAll = "SELECT `hospital_unit`, `mobile`, h.address, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE h.relevant_coordinator_id = u.id AND `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
                    $commandAll = Yii::app()->db->createCommand($sqlQueryAll)->queryAll();

                    $data['hospital_unit'] = $commandAll[0]['hospital_unit'];
                    $data['address'] = $commandAll[0]['address'];
                    $data['job_type'] = $commandAll[0]['job_type'];
                    $data['ward_name'] = $commandAll[0]['ward_name'];
                    $data['shift_start_datetime'] = Utility::changeDateToUK($command[0]['shift_start_datetime']) . " to " . Utility::changeTimeFromDateToUK($command[0]['shift_end_datetime']);

                    $commandUser = Utility::getStaff($post['staff_ids'][$i]);

//                    Utility::bookingShiftMail($data, $commandUser, $commandAll[0]['mobile']);

                    /*
                     * End of function
                     */

                    $afterBookingNonAvailability = new NonAvailabilityOfStaff;
                    $afterBookingNonAvailability->staff_id = $lo_enquiry_info->staff[$i];
                    $afterBookingNonAvailability->start_date = $lv_shiftStartDate;
                    $afterBookingNonAvailability->end_date = $lv_shiftEndDate;
                    $afterBookingNonAvailability->start_time = $lv_shiftStartTime;
                    $afterBookingNonAvailability->end_time = $lv_shiftEndTime;
                    $afterBookingNonAvailability->already_booked = 'Y';

                    if ($afterBookingNonAvailability->save()) {
                        $startDate = $afterBookingNonAvailability->start_date;
                        $endDate = $afterBookingNonAvailability->end_date;

                        $begin = new DateTime($startDate);
                        $end = new DateTime($endDate);

                        if ($lv_shiftStartTime < $lv_shiftEndTime)
                            date_add($end, date_interval_create_from_date_string('1 days'));
                        date_format($end, 'Y-m-d');

                        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

                        foreach ($daterange as $date) {
                            $nonRegularNonAvailability = new RegularNonAvailabilityOfStaff;
                            $date->format("Y-m-d") . "<br>";
                            $nonRegularNonAvailability->non_availablility_id = $afterBookingNonAvailability->non_availablility_id;
                            $nonRegularNonAvailability->date = $date->format("Y-m-d");
                            $nonRegularNonAvailability->start_time = $afterBookingNonAvailability->start_time;
                            $nonRegularNonAvailability->end_time = $afterBookingNonAvailability->end_time;
                            $nonRegularNonAvailability->already_booked = 'Y';
                            $nonRegularNonAvailability->save();
                        }
                    }
                }
            }
            if (count($lo_enquiry_info->staff) == $i) {
                return 'success';
            } else {
                return 'error';
            }
        }
    }

    public function getStaffsWhomEnquirySendNotConfirmed($lo_info) {
        $staff = array();
        $staffs = array();
        $j = 0;
        Yii::import('application.modules.admin.controllers.ShiftManagementForHospitalController');
        $staffs = ShiftManagementForHospitalController::getAvailableStaffAll($lo_info->staffRequestId, Utility::changeDateToMysql($lo_info->shiftStartDatetime), Utility::changeDateToMysql($lo_info->shiftEndDatetime), $lo_info->jobTypeId, $lo_info->hospitalUnitId);

        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour FROM {{user}} usr, {{shift_enquiry_ack}} ack, {{staff_registration}} stf WHERE ack.staff_id=usr.id AND `availability_confirmed_by_staff` = 'N' AND usr.staff_id = stf.staff_id AND ack.staff_request_id = '" . $lo_info->staffRequestId . "'";
        $rawData = Yii::app()->db->createCommand($sql)->queryAll();
        ; //or use ->queryAll(); in CArrayDataProvider
        foreach ($rawData AS $k => $rawValue) {
            foreach ($staffs AS $l => $staffsValue) {
                if ($rawValue['staff_id'] == $staffsValue[0]) {
                    $staff[$j] = $rawValue;
                    $staff[$j++]['allowed_hours'] = $staffsValue['allowed_hours'];
                    break;
                }
            }
        }
        if ($staff) {
            return $staff;
        } else {
            return 'no data';
        }
    }

    public function confirmShift($lo_confirmShiftInfo) {

        $sqlQuery1 = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $lo_confirmShiftInfo->staff_request_id . "' AND `staff_id` = " . $lo_confirmShiftInfo->staff_id;
        $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();

        $data = array(
            "availability_confirmed_via" => $lo_confirmShiftInfo->via,
            "availability_confirmed_by_staff" => 'Y',
            "confirmed_by" => 'C'
        );
        $update = Yii::app()->db->createCommand()
                ->update('ams_shift_enquiry_ack', $data, 'enquiry_id=:id', array(':id' => $command1['0']['enquiry_id'])
        );
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function getStaffsWhoConfirmedTheirAvailability($lo_info) {
        $staff = array();
        $staffs = array();
        $j = 0;

        Yii::import('application.modules.admin.controllers.ShiftManagementForHospitalController');
        $staffs = ShiftManagementForHospitalController::getAvailableStaffAll($lo_info->staffRequestId, Utility::changeDateToMysql($lo_info->shiftStartDatetime), Utility::changeDateToMysql($lo_info->shiftEndDatetime), $lo_info->jobTypeId, $lo_info->hospitalUnitId);

        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour FROM {{user}} usr, {{shift_enquiry_ack}} ack, {{staff_registration}} stf WHERE ack.staff_id=usr.id AND `availability_confirmed_by_staff` = 'Y' AND ack.is_confirmed = 'N' AND usr.staff_id = stf.staff_id AND ack.staff_request_id = '" . $lo_info->staffRequestId . "'";
        $rawData = Yii::app()->db->createCommand($sql)->queryAll(); //or use ->queryAll(); in CArrayDataProvider
        foreach ($rawData AS $k => $rawValue) {
            foreach ($staffs AS $l => $staffsValue) {
                if ($rawValue['staff_id'] == $staffsValue[0]) {
                    $staff[$j] = $rawValue;
                    $staff[$j++]['allowed_hours'] = $staffsValue['allowed_hours'];
                    break;
                }
            }
        }
        if ($staff) {
            return $staff;
        } else {
            return 'no data';
        }
    }

    public function allocateShift($lo_allocateShiftInfo) {
        $ls_res = "";
        $sqlQuery = "SELECT `shift_start_datetime`, `shift_end_datetime`, `quantity_confirmed`, `quantity` FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $lo_allocateShiftInfo->staff_request_id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $count = $command[0]['quantity_confirmed'];

        if ($command[0]['quantity_confirmed'] == $command[0]['quantity']) {
            $ls_res = 'fulfilled';
            return $ls_res;
        } else if ($command[0]['quantity_confirmed'] < $command[0]['quantity']) {
            $count = $count + 1;
            $modelBooking = new Booking;
            $modelBooking->staff_request_id = $lo_allocateShiftInfo->staff_request_id;
            $modelBooking->staff_id = $lo_allocateShiftInfo->staff_id;
            $modelBooking->confirmation_date = date("Y-m-d");
            $modelBooking->confirmation_time = date("H:i:s");
            $modelBooking->confirm_by_whom = 'C';
            $modelBooking->cancel_by_whom = '0';
            $modelBooking->cancellation_date = "0000-00-00";
            $modelBooking->cancellation_time = "00:00:00";
            $modelBooking->cancel_requested_by = "";

            $ls_chk = "";
            if ($modelBooking->save()) {

                /*
                 * Start Confirmation Mail function
                 */
                $data = array();
                $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $lo_allocateShiftInfo->staff_request_id . "'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

                $sqlQueryAll = "SELECT `hospital_unit`, `mobile`, h.address, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE h.relevant_coordinator_id = u.id AND `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
                $commandAll = Yii::app()->db->createCommand($sqlQueryAll)->queryAll();

                $data['hospital_unit'] = $commandAll[0]['hospital_unit'];
                $data['address'] = $commandAll[0]['address'];
                $data['job_type'] = $commandAll[0]['job_type'];
                $data['ward_name'] = $commandAll[0]['ward_name'];
                $data['shift_start_datetime'] = Utility::changeDateToUK($command[0]['shift_start_datetime']) . " to " . Utility::changeTimeFromDateToUK($command[0]['shift_end_datetime']);

                $commandUser = Utility::getStaff($lo_allocateShiftInfo->staff_id);
//                Utility::bookingShiftMail($data, $commandUser, $commandAll[0]['mobile']);

                /*
                 * End of function
                 */

                $lv_shiftStartDate = substr($command[0]['shift_start_datetime'], 0, 10);
                $lv_shiftStartTime = substr($command[0]['shift_start_datetime'], 11);

                $lv_shiftEndDate = substr($command[0]['shift_end_datetime'], 0, 10);
                $lv_shiftEndTime = substr($command[0]['shift_end_datetime'], 11);

                $data = array(
                    "quantity_confirmed" => $count
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $lo_allocateShiftInfo->staff_request_id)
                );
                $data = array(
                    "agent_user_id" => $lo_allocateShiftInfo->user_id,
                    "is_confirmed" => 'Y'
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_enquiry_ack', $data, 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $lo_allocateShiftInfo->staff_id, ':staff_request_id' => $lo_allocateShiftInfo->staff_request_id)
                );

                $afterBookingNonAvailability = new NonAvailabilityOfStaff;
                $afterBookingNonAvailability->staff_id = $lo_allocateShiftInfo->staff_id;
                $afterBookingNonAvailability->start_date = $lv_shiftStartDate;
                $afterBookingNonAvailability->end_date = $lv_shiftEndDate;
                $afterBookingNonAvailability->start_time = $lv_shiftStartTime;
                $afterBookingNonAvailability->end_time = $lv_shiftEndTime;
                $afterBookingNonAvailability->already_booked = 'Y';
                if ($afterBookingNonAvailability->save()) {
                    $startDate = $afterBookingNonAvailability->start_date;
                    $endDate = $afterBookingNonAvailability->end_date;

                    $begin = new DateTime($startDate);
                    $end = new DateTime($endDate);

                    if ($lv_shiftStartTime < $lv_shiftEndTime)
                        date_add($end, date_interval_create_from_date_string('1 days'));
                    date_format($end, 'Y-m-d');

                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

                    foreach ($daterange as $date) {
                        $nonRegularNonAvailability = new RegularNonAvailabilityOfStaff;
                        $date->format("Y-m-d") . "<br>";
                        $nonRegularNonAvailability->non_availablility_id = $afterBookingNonAvailability->non_availablility_id;
                        $nonRegularNonAvailability->date = $date->format("Y-m-d");
                        $nonRegularNonAvailability->start_time = $afterBookingNonAvailability->start_time;
                        $nonRegularNonAvailability->end_time = $afterBookingNonAvailability->end_time;
                        $nonRegularNonAvailability->already_booked = 'Y';
                        $nonRegularNonAvailability->save();
                    }
                }
                $ls_chk = "success";
            }
            if ($ls_chk == "success") {
                $ls_res = 'success';
                return $ls_res;
            } else {
                $ls_res = 'error';
                return $ls_res;
            }
        }
    }

    public function getStaffsBookedForThisShift($staff_request_id) {

        $staffs = array();
        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour FROM {{user}} usr, {{booking}} b, {{shift_enquiry_ack}} ack, {{staff_registration}} stf WHERE ack.staff_id=usr.id AND b.staff_request_id=ack.staff_request_id AND b.staff_id = ack.staff_id AND `availability_confirmed_by_staff` = 'Y' AND ack.is_confirmed = 'Y' AND usr.staff_id = stf.staff_id AND ack.staff_request_id = '" . $staff_request_id . "' AND b.cancel_by_whom = 0 ORDER BY stf.first_name";
        $staffs = Yii::app()->db->createCommand($sql)->queryAll(); //or use ->queryAll(); in CArrayDataProvider      
        if ($staffs) {
            return $staffs;
        } else {
            return 'no data';
        }
    }

    public function sendSms($lo_info) {

        $data = array();
        $sqlQueryForReminder = "SELECT u.first_name, u.email, u.mobile, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} sr WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND u.staff_id = sr.staff_id AND sr.staff_status = 'A' AND s.staff_request_id = '" . $lo_info->staff_request_id . "' AND u.id = '" . $lo_info->staff_id . "'";
        $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

        $ls_reminder = '';
        foreach ($commandForReminder AS $lv_details) {
            $data['first_name'] = $lv_details['first_name'];
            $ls_reminder .= 'at ' . $lv_details["hospital_unit"] . ' on ' . Utility::changeDateToUK($lv_details["shift_start_datetime"]) . ' to ' . Utility::changeDateToUK($lv_details["shift_end_datetime"]);
        }
        $data['mobile'] = $lv_details['mobile'];
        $data['reminder'] = $ls_reminder;
        Utility::reminderSMS($data);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function rejection($lo_info) {

        $staffRequestId = $lo_info->staff_request_id;

        $sqlQuery1 = "SELECT * FROM {{booking}} WHERE `staff_request_id` = '" . $staffRequestId . "' AND `staff_id` = " . $lo_info->staff_id;
        $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();

        $chk = 0;
        $booking_id = $command1['0']['booking_id'];
        if ($lo_info->can_req_by) {

            $data = array(
                "cancel_requested_by" => $lo_info->can_req_by,
                "cancellation_date" => date("Y-m-d"),
                "cancellation_time" => date("H:i:s"),
                "cancel_by_whom" => $lo_info->user_id
            );
            $update = Yii::app()->db->createCommand()
                    ->update('ams_booking', $data, 'booking_id=:booking_id', array(':booking_id' => $booking_id)
            );

            if ($update) {
                $sqlQuery = "SELECT `shift_start_datetime`, `shift_end_datetime`, `quantity_confirmed`, `quantity` FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $staffRequestId;
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                $count = $command[0]['quantity_confirmed'];
                $count = $count - 1;

                $lv_shiftStartDate = substr($command[0]['shift_start_datetime'], 0, 10);
                $lv_shiftStartTime = substr($command[0]['shift_start_datetime'], 11);

                $lv_shiftEndDate = substr($command[0]['shift_end_datetime'], 0, 10);
                $lv_shiftEndTime = substr($command[0]['shift_end_datetime'], 11);

                $data = array(
                    "quantity_confirmed" => $count
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $staffRequestId)
                );

                $sqlQuery = "SELECT `non_availablility_id`, `staff_id` FROM {{non_availability_of_staff}} WHERE `start_date` = '" . $lv_shiftStartDate . "' AND `end_date` = '" . $lv_shiftEndDate . "' AND `start_time` = '" . $lv_shiftStartTime . "' AND `end_time` = '" . $lv_shiftEndTime . "' AND `already_booked` = 'Y'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                $lv_nonAvailablilityId = $command[0]['non_availablility_id'];

                $li_staff_id = $command[0]['staff_id'];

                Yii::app()->db->createCommand()->delete('ams_non_availability_of_staff', 'non_availablility_id =' . $lv_nonAvailablilityId);

                $command = Yii::app()->db->createCommand("SELECT * FROM {{regular_non_availability_of_staff}} WHERE `non_availablility_id`=" . $lv_nonAvailablilityId)->queryAll();
                foreach ($command as $li_dDate) {
                    Yii::app()->db->createCommand()->delete('ams_regular_non_availability_of_staff', 'id =' . $li_dDate['id']);
                }

                /*
                 * Start cancel shift mail function
                 */
                $data = array();
                $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $staffRequestId . "'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

                $sqlQueryAll = "SELECT `hospital_unit`, `mobile`, h.address, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE h.relevant_coordinator_id = u.id AND `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
                $commandAll = Yii::app()->db->createCommand($sqlQueryAll)->queryAll();

                $data['hospital_unit'] = $commandAll[0]['hospital_unit'];
                $data['address'] = $commandAll[0]['address'];
                $data['job_type'] = $commandAll[0]['job_type'];
                $data['ward_name'] = $commandAll[0]['ward_name'];
                $data['shift_start_datetime'] = Utility::changeDateToUK($command[0]['shift_start_datetime']);
                $data['shift_end_datetime'] = Utility::changeDateToUK($command[0]['shift_end_datetime']);

                $commandUser = Utility::getStaff($li_staff_id);

                Utility::sendCancellationMail($data, $commandUser[0]['first_name'], $commandUser[0]['email'], $commandUser[0]['mobile'], $commandAll[0]['mobile']);
                /*
                 * End of function
                 */
                $chk = 1;
            }
        }

        if ($chk == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getCancelAfterBookedStaffList($staff_request_id) {

        $staffs = array();
        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour,b.cancel_by_whom "
                . " FROM  {{booking}} b  "
                . " LEFT JOIN  {{shift_enquiry_ack}} ack  ON  b.staff_request_id=ack.staff_request_id"
                . " LEFT JOIN {{user}} usr  ON ack.staff_id=usr.id"
                . "  LEFT JOIN {{staff_registration}} stf ON usr.staff_id = stf.staff_id"
                . " WHERE  `availability_confirmed_by_staff` = 'Y' AND b.staff_id = ack.staff_id AND  b.staff_request_id = '" . $staff_request_id . "' AND b.cancel_by_whom != 0 ORDER BY stf.first_name";

        $staffs = Yii::app()->db->createCommand($sql)->queryAll(); //or use ->queryAll(); in CArrayDataProvider      

        if ($staffs) {
            return $staffs;
        } else {
            return 'no data';
        }
    }

    public function allocateShiftAgain($lo_allocateShiftInfo) {

//        print_r($lo_allocateShiftInfo);die;

        $staffRequestId = $lo_allocateShiftInfo->staff_request_id;
        $staffId = $lo_allocateShiftInfo->staff_id;
        $userId = $lo_allocateShiftInfo->user_id;
        $ls_res = "";

        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $staffRequestId;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $count = $command[0]['quantity_confirmed'];

        Yii::import('application.modules.admin.controllers.ShiftManagementForHospitalController');
        $staffs = ShiftManagementForHospitalController::getAvailableStaffAll($staffRequestId, $command[0]['shift_start_datetime'], $command[0]['shift_end_datetime'], $command[0]['job_type_id'], $command[0]['hospital_unit_id']);

        $lf_flag = 0;
        foreach ($staffs as $record) {
            if ($record[0] == $staffId) {
                $sqlQueryForStaff = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $staffRequestId . "' AND `staff_id` = " . $record[0];
                $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();
                if (count($commandForStaff) != 0) {
                    $lf_flag = 1;
                    break;
                }
            }
        }

        if (($command[0]['quantity_confirmed'] < $command[0]['quantity']) && ($lf_flag == 1)) {
            $count = $count + 1;

            $data = array(
                "confirmation_date" => date("Y-m-d"),
                "confirmation_time" => date("H:i:s"),
                "confirm_by_whom" => 'C',
                "cancel_by_whom" => '0',
                "cancellation_date" => "0000-00-00",
                "cancellation_time" => "00:00:00",
                "cancel_requested_by" => ""
            );
            $update = Yii::app()->db->createCommand()
                    ->update('ams_booking', $data, 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $staffId, ':staff_request_id' => $staffRequestId)
            );

            if ($update) {

                /*
                 * Start Confirmation Mail function
                 */
                $data = array();
                $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $staffRequestId . "'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

                $sqlQueryAll = "SELECT `hospital_unit`, `mobile`, h.address, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE h.relevant_coordinator_id = u.id AND `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
                $commandAll = Yii::app()->db->createCommand($sqlQueryAll)->queryAll();

                $data['hospital_unit'] = $commandAll[0]['hospital_unit'];
                $data['address'] = $commandAll[0]['address'];
                $data['job_type'] = $commandAll[0]['job_type'];
                $data['ward_name'] = $commandAll[0]['ward_name'];
                $data['shift_start_datetime'] = Utility::changeDateToUK($command[0]['shift_start_datetime']) . " to " . Utility::changeTimeFromDateToUK($command[0]['shift_end_datetime']);

                $commandUser = Utility::getStaff($staffId);
//                Utility::bookingShiftMail($data, $commandUser, $commandAll[0]['mobile']);

                /*
                 * End of function
                 */

                $lv_shiftStartDate = substr($command[0]['shift_start_datetime'], 0, 10);
                $lv_shiftStartTime = substr($command[0]['shift_start_datetime'], 11);

                $lv_shiftEndDate = substr($command[0]['shift_end_datetime'], 0, 10);
                $lv_shiftEndTime = substr($command[0]['shift_end_datetime'], 11);

                $data = array(
                    "quantity_confirmed" => $count
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $staffRequestId)
                );
                $data = array(
                    "agent_user_id" => $userId,
                    "is_confirmed" => 'Y'
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_enquiry_ack', $data, 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $staffId, ':staff_request_id' => $staffRequestId)
                );

                $afterBookingNonAvailability = new NonAvailabilityOfStaff;
                $afterBookingNonAvailability->staff_id = $staffId;
                $afterBookingNonAvailability->start_date = $lv_shiftStartDate;
                $afterBookingNonAvailability->end_date = $lv_shiftEndDate;
                $afterBookingNonAvailability->start_time = $lv_shiftStartTime;
                $afterBookingNonAvailability->end_time = $lv_shiftEndTime;
                $afterBookingNonAvailability->already_booked = 'Y';
                if ($afterBookingNonAvailability->save()) {
                    $startDate = $afterBookingNonAvailability->start_date;
                    $endDate = $afterBookingNonAvailability->end_date;

                    $begin = new DateTime($startDate);
                    $end = new DateTime($endDate);

                    if ($lv_shiftStartTime < $lv_shiftEndTime)
                        date_add($end, date_interval_create_from_date_string('1 days'));
                    date_format($end, 'Y-m-d');

                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

                    foreach ($daterange as $date) {
                        $nonRegularNonAvailability = new RegularNonAvailabilityOfStaff;
                        $date->format("Y-m-d") . "<br>";
                        $nonRegularNonAvailability->non_availablility_id = $afterBookingNonAvailability->non_availablility_id;
                        $nonRegularNonAvailability->date = $date->format("Y-m-d");
                        $nonRegularNonAvailability->start_time = $afterBookingNonAvailability->start_time;
                        $nonRegularNonAvailability->end_time = $afterBookingNonAvailability->end_time;
                        $nonRegularNonAvailability->already_booked = 'Y';
                        $nonRegularNonAvailability->save();
                    }
                    $ls_res = 'success';
                }
            }
        } elseif ($command[0]['quantity_confirmed'] == $command[0]['quantity']) {
            $ls_res = 'fulfilled';
        }
        if ($lf_flag == 0) {
            $ls_res = 'assigned';
        }
        return $ls_res;
    }

    public function getAllUnfilledShiftLists() {
        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT sm.*,hu.hospital_unit,j.job_type,u.email FROM {{shift_management_for_hospital}} sm, {{hospital_unit}} hu, {{user}} u, {{job_type}} j WHERE sm.hospital_unit_id = hu.hospital_unit_id AND sm.job_type_id = j.job_type_id AND sm.request_accepted_by = u.id AND sm.shift_start_datetime > '" . $date . "' AND sm.status = 'A' ORDER BY sm.staff_request_id DESC";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;
        foreach ($la_qry_res as $value) {
            if ($value['quantity'] != $value['quantity_confirmed']) {
                $la_resultArray[$i] = $value;
                $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);
                $i++;
            }
        }

        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getAllArchiveShiftLists() {
        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT sm.*,hu.hospital_unit,j.job_type,u.email FROM {{shift_management_for_hospital}} sm, {{hospital_unit}} hu, {{user}} u, {{job_type}} j WHERE sm.hospital_unit_id = hu.hospital_unit_id AND sm.job_type_id = j.job_type_id AND sm.request_accepted_by = u.id AND sm.shift_start_datetime < '" . $date . "' OR `status` = 'Ar' AND sm.status = 'A' ORDER BY sm.staff_request_id DESC";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;
        foreach ($la_qry_res as $value) {
            $la_resultArray[$i] = $value;
            $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
            $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);
            $i++;
        }

        if ($la_qry_res) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

    public function getAllHistoricalFilledShiftLists() {
        $date = date('Y-m-d H:i:s');
        $sqlQuery = "SELECT sm.*,hu.hospital_unit,j.job_type,u.email FROM {{shift_management_for_hospital}} sm, {{hospital_unit}} hu, {{user}} u, {{job_type}} j WHERE sm.hospital_unit_id = hu.hospital_unit_id AND sm.job_type_id = j.job_type_id AND sm.request_accepted_by = u.id AND sm.shift_start_datetime < '" . $date . "' AND sm.status = 'A' ORDER BY sm.staff_request_id DESC";
        $la_qry_res = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;
        foreach ($la_qry_res as $value) {
            if ($value['quantity'] == $value['quantity_confirmed']) {
                $la_resultArray[$i] = $value;
                $la_resultArray[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_start_datetime']);
                $la_resultArray[$i]['shift_end_datetime'] = Utility::changeDateToUK($la_resultArray[$i]['shift_end_datetime']);
                $i++;
            }
        }

        if ($la_resultArray) {
            return $la_resultArray;
        } else {
            return 'no data';
        }
    }

}

?>