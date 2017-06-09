<?php

class ShiftManagementForHospitalController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'sendEnquiryAll', 'SendSMSOrMail', 'getDragStaffDetails', 'valueForBar', 'sendDragStaffDetails', 'SendSMS', 'admin', 'AdminArchive', 'AdminSelf', 'AdminUnfilled', 'AdminHistoricalFilled', 'delete', 'booking', 'allocate', 'directAllocation', 'directConfirmation', 'create', 'update', 'booking', 'confirm', 'againconfirm', 'cancel', 'AddMoreShift', 'sendEnquiry', 'getAvailableStaffAll', 'getContactNumberForHospital', 'getWardForHospital', 'autocomplete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $model->shift_start_datetime = Utility::changeDateToUK($model->shift_start_datetime);
        $model->shift_end_datetime = Utility::changeDateToUK($model->shift_end_datetime);
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model with all booking of that shift
     * @param integer $id the ID of the model to be displayed
     */
    public function actionBooking($id) {
        $model = $this->loadModel($id);

        $available_staffs = $this->getAvailableStaff($model->staff_request_id, $model->shift_start_datetime, $model->shift_end_datetime, $model->job_type_id, $model->hospital_unit_id);
        $not_confirmed_staff = $this->getNotConfirmedStaff($model->staff_request_id, $model->shift_start_datetime, $model->shift_end_datetime, $model->job_type_id, $model->hospital_unit_id);
        $confirmed_staff = $this->getConfirmedStaff($model->staff_request_id, $model->shift_start_datetime, $model->shift_end_datetime, $model->job_type_id, $model->hospital_unit_id);

        $bookedStaff = $this->getBookedStaff($model->staff_request_id);
        $cancel_after_confirmed_shift = $this->getCancelAfterConfirmedShift($model->staff_request_id);
        $model->shift_start_datetime = Utility::changeDateToUK($model->shift_start_datetime);
        $model->shift_end_datetime = Utility::changeDateToUK($model->shift_end_datetime);

        $lf_checkExpiry = Utility::checkShiftExpiryStatus($model->shift_start_datetime);
        $this->render('booking', array(
            'model' => $model,
            'model_staff' => $available_staffs,
            'model_not_confirmed_staff' => $not_confirmed_staff,
            'model_confirmed_staff' => $confirmed_staff,
            'model_booked_staff' => $bookedStaff,
            'model_cancel_after_confirmed_shift' => $cancel_after_confirmed_shift,
            'lf_checkExpiry' => $lf_checkExpiry
        ));
    }

    public function actiongetDragStaffDetails() {
        $sqlQueryForShiftId = "SELECT s.staff_request_id, s.hospital_unit_id, s.shift_start_datetime, s.shift_end_datetime  FROM {{shift_management_for_hospital}} s WHERE s.hospital_unit_id = '" . $_GET['hospitalId'] . "' AND ('" . $_GET['date'] . "' BETWEEN s.shift_start_datetime AND s.shift_end_datetime OR s.shift_start_datetime LIKE '" . $_GET['date'] . "%')";
        $commandForShiftId = Yii::app()->db->createCommand($sqlQueryForShiftId)->queryAll();

        $sqlQueryForStaffDetails = "SELECT u.email, u.first_name, u.last_name  FROM {{user}} u WHERE u.id = '" . $_GET['id'] . "'";
        $commandForStaffDetails = Yii::app()->db->createCommand($sqlQueryForStaffDetails)->queryAll();

        $la_staffId = array();
        $i = 0;
        foreach ($commandForShiftId AS $la_shiftId) {
            $la_shiftId['shift_start_datetime'] = Utility::changeDateToUK($la_shiftId['shift_start_datetime']);
            $la_shiftId['shift_end_datetime'] = Utility::changeDateToUK($la_shiftId['shift_end_datetime']);

            $la_staffId[$i] = $la_shiftId;
            $la_staffId[$i]['staff_email'] = $commandForStaffDetails[0]['email'];
            $la_staffId[$i++]['staff_name'] = $commandForStaffDetails[0]['first_name'] . " " . $commandForStaffDetails[0]['last_name'];
        }
        print_r(json_encode($la_staffId));
    }

    public function actionsendDragStaffDetails() {
        $sqlQueryForShiftDetails = "SELECT *  FROM {{shift_management_for_hospital}} s WHERE s.staff_request_id = '" . $_GET['staffRequestId'] . "'";
        $commandForShiftDetails = Yii::app()->db->createCommand($sqlQueryForShiftDetails)->queryAll();

        $ld_currentDate = date("Y-m-d H:i:s");
        if ($ld_currentDate < $commandForShiftDetails[0]['shift_start_datetime']) {
            $staffDetails = $this->getAvailableStaffAll($commandForShiftDetails[0]['staff_request_id'], $commandForShiftDetails[0]['shift_start_datetime'], $commandForShiftDetails[0]['shift_end_datetime'], $commandForShiftDetails[0]['job_type_id'], $commandForShiftDetails[0]['hospital_unit_id']);
            $status = "Staff not eligible or available for this shift";
            foreach ($staffDetails AS $la_staff) {
                if ($la_staff['email'] == $_GET['staffEmail']) {
                    $sqlQueryForStaff = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $commandForShiftDetails[0]['staff_request_id'] . "' AND `staff_id` = " . $la_staff[0];
                    $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();

                    $sqlQueryForStaffRejectOrNot = "SELECT * FROM {{booking}} WHERE `staff_request_id` = '" . $commandForShiftDetails[0]['staff_request_id'] . "' AND `staff_id` = " . $la_staff[0];
                    $commandForStaffRejectOrNot = Yii::app()->db->createCommand($sqlQueryForStaffRejectOrNot)->queryAll();

                    if (count($commandForStaffRejectOrNot) == 0) {
                        if (count($commandForStaff) == 0) {
                            $status = $this->dragDropDirectConfirmation($commandForShiftDetails[0]['staff_request_id'], $la_staff[0]);
                            break;
                        } else {
                            $status = $this->dragDropDirectConfirmationAfterEnquiry($commandForShiftDetails[0]['staff_request_id'], $la_staff[0], $commandForStaff[0]['enquiry_id']);
                            break;
                        }
                    } else {
                        $la_staffStatus = YII::app()->params['staffType'];
                        $ls_rejectedBy = "";
                        foreach ($la_staffStatus as $x => $x_value) {
                            if ($x == $commandForStaffRejectOrNot[0]['cancel_requested_by']) {
                                $ls_rejectedBy = $x_value;
                            }
                        }
                        $status = "Staff already assigned for this shift and rejected by " . $ls_rejectedBy;
                        break;
                    }
                }
            }

            if ($status == "Staff not eligible or available for this shift") {
                $sqlQueryForStaffAlreadyAssigned = "SELECT b.staff_request_id FROM {{booking}} b, {{user}} u WHERE b.staff_id = u.id AND b.staff_request_id = '" . $_GET['staffRequestId'] . "' AND u.email = '" . $_GET['staffEmail'] . "'";
                $commandForStaffAlreadyAssigned = Yii::app()->db->createCommand($sqlQueryForStaffAlreadyAssigned)->queryAll();
                if (count($commandForStaffAlreadyAssigned) == 1) {
                    $status = "Staff already assigned for this shift";
                }
            }
        } else {
            $status = "Previous shift cannot be allocated";
        }
        echo $status;
    }

    public function dragDropDirectConfirmationAfterEnquiry($staffRequestId, $staffIds, $enquiryId) {
        $sqlQuery = "SELECT `shift_start_datetime`, `shift_end_datetime`, `quantity_confirmed`, `quantity` FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $staffRequestId;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $count = $command[0]['quantity_confirmed'];
        if ($command[0]['quantity_confirmed'] < $command[0]['quantity']) {

            $data = array(
                "staff_request_id" => $staffRequestId,
                "staff_id" => $staffIds,
                "enquired_by" => $_SESSION['logged_user']['id'],
                "availability_confirmed_by_staff" => 'Y',
                "availability_confirmed_via" => 'By phone',
                "confirmed_by" => $_SESSION['logged_user']['type'],
                "agent_user_id" => $_SESSION['logged_user']['id'],
                "is_confirmed" => 'Y'
            );
            $update = Yii::app()->db->createCommand()
                    ->update('ams_shift_enquiry_ack', $data, 'enquiry_id=:enquiry_id', array(':enquiry_id' => $enquiryId)
            );

            $count = $count + 1;

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
            $modelBooking = new Booking;
            $modelBooking->staff_request_id = $staffRequestId;
            $modelBooking->staff_id = $staffIds;
            $modelBooking->confirmation_date = date("Y-m-d");
            $modelBooking->confirmation_time = date("H:i:s");
            $modelBooking->confirm_by_whom = $_SESSION['logged_user']['type'];
            $modelBooking->cancel_by_whom = '0';
            $modelBooking->cancellation_date = "0000-00-00";
            $modelBooking->cancellation_time = "00:00:00";
            $modelBooking->cancel_requested_by = "";

            if ($modelBooking->save()) {

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

                $commandUser = Utility::getStaff($staffIds);
//                Utility::bookingShiftMail($data, $commandUser, $commandAll[0]['mobile']);

                /*
                 * End of function
                 */

                $afterBookingNonAvailability = new NonAvailabilityOfStaff;
                $afterBookingNonAvailability->staff_id = $staffIds;
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
            $status = "Shift has been successfully assigned";
        } else {
            $status = "Shift has been fulfilled";
        }
        return $status;
    }

    public function dragDropDirectConfirmation($staffRequestId, $staffIds) {
        $sqlQuery = "SELECT `shift_start_datetime`, `shift_end_datetime`, `quantity_confirmed`, `quantity` FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $staffRequestId;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $count = $command[0]['quantity_confirmed'];
        if ($command[0]['quantity_confirmed'] < $command[0]['quantity']) {
            $modelAck = new ShiftEnquiryAck;
            $modelAck->staff_request_id = $staffRequestId;
            $modelAck->staff_id = $staffIds;
            $modelAck->enquired_by = $_SESSION['logged_user']['id'];
            $modelAck->availability_confirmed_by_staff = 'Y';
            $modelAck->availability_confirmed_via = "By phone";
            $modelAck->confirmed_by = $_SESSION['logged_user']['type'];
            $modelAck->agent_user_id = $_SESSION['logged_user']['id'];
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
                    ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $staffRequestId)
            );
            $modelBooking = new Booking;
            $modelBooking->staff_request_id = $staffRequestId;
            $modelBooking->staff_id = $staffIds;
            $modelBooking->confirmation_date = date("Y-m-d");
            $modelBooking->confirmation_time = date("H:i:s");
            $modelBooking->confirm_by_whom = $_SESSION['logged_user']['type'];
            $modelBooking->cancel_by_whom = '0';
            $modelBooking->cancellation_date = "0000-00-00";
            $modelBooking->cancellation_time = "00:00:00";
            $modelBooking->cancel_requested_by = "";

            if ($modelBooking->save()) {

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

                $commandUser = Utility::getStaff($staffIds);
//                Utility::bookingShiftMail($data, $commandUser, $commandAll[0]['mobile']);

                /*
                 * End of function
                 */

                $afterBookingNonAvailability = new NonAvailabilityOfStaff;
                $afterBookingNonAvailability->staff_id = $staffIds;
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
            $status = "Shift has been successfully assigned";
        } else {
            $status = "Shift has been fulfilled";
        }
        return $status;
    }

    /**
     * Displays a particular model with all booking of that shift
     * @param integer $id the ID of the model to be displayed
     */
    public function getAvailableStaffAll($staffRequestId, $shiftStartDatetime, $shiftEndDtetime, $jobTypeId, $hospitalUnitId) {
        $startDatetimeArr = explode(' ', $shiftStartDatetime);
        $startDate = $startDatetimeArr[0];
        $startTime = $startDatetimeArr[1];
        $shiftEndDtetimeArr = explode(' ', $shiftEndDtetime);
        $endDate = $shiftEndDtetimeArr[0];
        $endTime = $shiftEndDtetimeArr[1];
        $staffs = array();
        $staff = array();
        $la_staffNotWorkThisHospital = array();
        $la_staffWorkThisHospital = array();
        $la_staffAll = array();
        $la_getStaff = array();
        $sqlQueryForWorkAreaId = "SELECT h.local_area_id, h.training_needed FROM {{hospital_unit}} h WHERE h.hospital_unit_id = '" . $hospitalUnitId . "'";

        $commandForWorkAreaId = Yii::app()->db->createCommand($sqlQueryForWorkAreaId)->queryAll();

        $la_training_needed = explode(", ", $commandForWorkAreaId[0]['training_needed']);

        $sqlQuery = "SELECT * FROM {{staff_registration}} s, {{staff_job_type_map}} sm, {{staff_registration_preferred_work_area_map_table}} sw WHERE s.staff_id = sm.staff_id AND s.staff_id = sw.staff_id AND s.staff_status = 'A'  AND s.visa_expiry_date > '" . $endDate . "' AND sm.job_type_id = '" . $jobTypeId . "' AND sw.work_area_id = '" . $commandForWorkAreaId[0]['local_area_id'] . "' ORDER BY s.first_name";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;
        $j = 0;
        foreach ($command as $rec) {
            $sqlQuery1 = "SELECT * FROM {{user}} WHERE `active_status` = 'Y' AND `staff_id` = " . $rec['staff_id'];
            $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
            if (count($command1) > 0) {
                $rec_id = $command1[0]['id'];

                $sqlQuery2 = "SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $rec_id . " AND `date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND '" . $startTime . "' BETWEEN r.start_time AND r.end_time
                                        UNION
                                        SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $rec_id . " AND `date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND '" . $endTime . "' BETWEEN r.start_time AND r.end_time
                                        UNION
                                        SELECT `staff_id`, `date`, r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND n.staff_id = " . $rec_id . " AND `date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND '" . $startTime . "' <= r.start_time AND r.start_time<='" . $endTime . "'
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE '" . $startDate . "' BETWEEN `start_date` AND `end_date` AND `staff_id` = " . $rec_id . "
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE '" . $endDate . "' BETWEEN `start_date` AND `end_date` AND `staff_id` = " . $rec_id . "
                                        UNION
                                        SELECT * FROM {{holiday}} WHERE `start_date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND `staff_id` = " . $rec_id;

                $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();
                if (count($command2) == 0) {
                    array_push($rec, $rec_id);
                    $staffs[$i++] = $rec;
                }
            }
        }
        foreach ($staffs as $record) {
            $time = strtotime($shiftStartDatetime);
            $currentMonth = date("Y-m", $time);

            $sqlQueryForStaff = "SELECT r.start_time, r.end_time FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND r.already_booked = 'Y' AND r.date LIKE '%" . $currentMonth . "%' AND n.staff_id = " . $record[0];
            $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();

            $hours = 0;
            foreach ($commandForStaff as $records) {

                $lt_start_time = strtotime($records['start_time']);
                $lt_end_time = strtotime($records['end_time']);


                if ($lt_end_time < $lt_start_time)
                    $lt_end_time += 86400;
                $hours += ($lt_end_time - $lt_start_time) / 3600;
            }
//            if ($hours <= $record['max_allowed_hour']) {
            $staff[$j] = $record;
            $staff[$j++]['allowed_hours'] = abs($hours);
//            }
        }

        $i = 0;
        $j = 0;
        foreach ($staff AS $records) {
            $sqlQueryForStaff = "SELECT s.hospital_unit_id "
                    . "FROM {{shift_management_for_hospital}} s, {{booking}} b "
                    . "WHERE s.staff_request_id = b.staff_request_id AND s.shift_start_datetime < '" . $shiftStartDatetime . "' AND b.staff_id = '" . $records[0] . "' "
                    . "AND s.hospital_unit_id = '" . $hospitalUnitId . "'";
            $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();

            if (count($commandForStaff) == 0) {
                $la_staffNotWorkThisHospital[$i] = $records;
                $la_staffNotWorkThisHospital[$i++]['flag'] = 0;
            } else {
                $la_staffWorkThisHospital[$j] = $records;
                $la_staffWorkThisHospital[$j++]['flag'] = 1;
            }
        }

        $k = 0;
        foreach ($la_staffWorkThisHospital AS $la_record) {
            $la_staffAll[$k++] = $la_record;
        }

        foreach ($la_staffNotWorkThisHospital AS $la_records) {
            $la_staffAll[$k++] = $la_records;
        }

        $i = 0;
        foreach ($la_staffAll AS $records) {
            $lf_expiry = 0;
            foreach ($la_training_needed AS $ls_traing) {
                if ($ls_traing == "Mandatory Training") {
                    if (($records['mandatory_training_expiry_date'] < $shiftStartDatetime) || ($records['mandatory_training_expiry_date'] == "0000-00-00")) {
                        $lf_expiry = 1;
                    }
                }

                if ($ls_traing == "MAYBO") {
                    if (($records['maybo_training_expiry'] < $shiftStartDatetime) || ($records['maybo_training_expiry'] == "0000-00-00")) {
                        $lf_expiry = 1;
                    }
                }

                if ($ls_traing == "PMVA") {
                    if (($records['pmva_expiry_date'] < $shiftStartDatetime) || ($records['pmva_expiry_date'] == "0000-00-00")) {
                        $lf_expiry = 1;
                    }
                }

                if ($ls_traing == "MAPA") {
                    if (($records['mapa_expiry_date'] < $shiftStartDatetime) || ($records['mapa_expiry_date'] == "0000-00-00")) {
                        $lf_expiry = 1;
                    }
                }
            }

            if ($lf_expiry == 0) {
                $la_getStaff[$i] = $records;
                $la_getStaff[$i++]['flagForExpiry'] = 0;
            } else {
                $la_getStaff[$i] = $records;
                $la_getStaff[$i++]['flagForExpiry'] = 1;
            }
        }
//        print_r($la_staffAll);die;
        return $la_getStaff;
    }

    /**
     * Displays a particular model with all booking of that shift
     * @param integer $id the ID of the model to be displayed
     */
    public function getAvailableStaff($staffRequestId, $shiftStartDatetime, $shiftEndDtetime, $jobTypeId, $hospitalUnitId) {
        $staff = array();
        $staffs = array();
        $j = 0;
        $staffs = $this->getAvailableStaffAll($staffRequestId, $shiftStartDatetime, $shiftEndDtetime, $jobTypeId, $hospitalUnitId);
        foreach ($staffs as $record) {
            $sqlQueryForStaff = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $staffRequestId . "' AND `staff_id` = " . $record[0];
            $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();
            if (count($commandForStaff) == 0) {
                $staff[$j++] = $record;
            }
        }
//        print_r($staff); 
//        die;
        $dataProvider = new CArrayDataProvider($staff, array(
            'sort' => array(
                'attributes' => array(
                    'staff_id', 'first_name', 'max_allowed_hour', 'mobile_no', 'email', '0', 'allowed_hours'
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        return $dataProvider;
    }

    public function getNotConfirmedStaff($staffRequestId, $shiftStartDatetime, $shiftEndDtetime, $jobTypeId, $hospitalUnitId) {
        $staff = array();
        $staffs = array();
        $j = 0;
        $staffs = $this->getAvailableStaffAll($staffRequestId, $shiftStartDatetime, $shiftEndDtetime, $jobTypeId, $hospitalUnitId);

        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour FROM {{user}} usr, {{shift_enquiry_ack}} ack, {{staff_registration}} stf WHERE ack.staff_id=usr.id AND `availability_confirmed_by_staff` = 'N' AND usr.staff_id = stf.staff_id AND ack.staff_request_id = '" . $staffRequestId . "'";
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
        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); //the count
        $dataProvider = new CArrayDataProvider($staff, array(
            'keyField' => 'enquiry_id',
            'totalItemCount' => $count,
            'sort' => array(
                'attributes' => array(
                    'allowed_hours', 'enquiry_id', 'staff_request_id', 'staff_id', 'enquired_by', 'availability_confirmed_by_staff', 'availability_confirmed_via', 'confirmed_by', 'agent_user_id', 'is_confirmed'
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        return $dataProvider;
    }

    public function getConfirmedStaff($staffRequestId, $shiftStartDatetime, $shiftEndDtetime, $jobTypeId, $hospitalUnitId) {
        $staff = array();
        $staffs = array();
        $j = 0;
        $staffs = $this->getAvailableStaffAll($staffRequestId, $shiftStartDatetime, $shiftEndDtetime, $jobTypeId, $hospitalUnitId);
        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour FROM {{user}} usr, {{shift_enquiry_ack}} ack, {{staff_registration}} stf WHERE ack.staff_id=usr.id AND `availability_confirmed_by_staff` = 'Y' AND ack.is_confirmed = 'N' AND usr.staff_id = stf.staff_id AND ack.staff_request_id = '" . $staffRequestId . "'";
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

        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); //the count
        $dataProvider = new CArrayDataProvider($staff, array(
            'keyField' => 'enquiry_id',
            'totalItemCount' => $count,
            'sort' => array(
                'attributes' => array(
                    'allowed_hours', 'enquiry_id', 'staff_request_id', 'staff_id', 'enquired_by', 'availability_confirmed_by_staff', 'availability_confirmed_via', 'confirmed_by', 'agent_user_id', 'is_confirmed'
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        return $dataProvider;
    }

    public function actionSendEnquiry() {
        if (isset($_POST['staff_ids'])) {
            $data = array();
            $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $_POST['staff_request_id'] . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

            $sqlQueryAll = "SELECT `hospital_unit`, `mobile`, h.address, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u WHERE h.relevant_coordinator_id = u.id AND `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
            $commandAll = Yii::app()->db->createCommand($sqlQueryAll)->queryAll();

            $data['hospital_unit'] = $commandAll[0]['hospital_unit'];
            $data['address'] = $commandAll[0]['address'];
            $data['job_type'] = $commandAll[0]['job_type'];
            $data['ward_name'] = $commandAll[0]['ward_name'];
            $data['shift_start_datetime'] = Utility::changeDateToUK($command[0]['shift_start_datetime']) . " to " . Utility::changeTimeFromDateToUK($command[0]['shift_end_datetime']);

            $post = $_POST;
//            $models = ShiftManagementForHospital::model()->find(array('condition' => 'staff_request_id=1'));
//            wDebug::debugObject($models->hospitalUnit->hospital_unit_id);
//            echo '-----------------------';
//            echo $models[0]['shift_start_datetime'];
//            $sqlQueryUser = "SELECT `email` FROM {{user}} WHERE `id` = '" . $post['staff_ids'][0] . "'";
//            $commandUser = Yii::app()->db->createCommand($sqlQueryUser)->queryAll();
//            echo $commandUser[0]['email'];
            for ($i = 0; $i < count($_POST['staff_ids']); $i++) {
                $modelAck = new ShiftEnquiryAck;
                $modelAck->staff_request_id = $post['staff_request_id'];
                $modelAck->staff_id = $post['staff_ids'][$i];
                $modelAck->enquired_by = $post['enquired_by'];
                $modelAck->confirmed_by = 'NA';
                $modelAck->agent_user_id = $post['enquired_by'];
                $modelAck->save();

                $commandUser = Utility::getStaff($post['staff_ids'][$i]);

                Utility::sendEnquiryMail($data, $commandUser[0]['first_name'], $commandUser[0]['email'], $commandUser[0]['mobile'], $commandAll[0]['mobile']);
            }
        }
        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/shiftManagementForHospital/booking', array('id' => $post['staff_request_id']));
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actionallocate($id, $staffId) {
        $sqlQuery1 = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $id . "' AND `staff_id` = " . $staffId;
        $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();

        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/shiftEnquiryAck/confirm', array('id' => $command1['0']['enquiry_id']));
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actiondirectAllocation() {
        if (isset($_POST['staff_ids'])) {
            $post = $_POST;
            for ($i = 0; $i < count($_POST['staff_ids']); $i++) {
                $modelAck = new ShiftEnquiryAck;
                $modelAck->staff_request_id = $post['staff_request_id'];
                $modelAck->staff_id = $post['staff_ids'][$i];
                $modelAck->enquired_by = $post['enquired_by'];
                $modelAck->availability_confirmed_by_staff = 'Y';
                $modelAck->availability_confirmed_via = "By phone";
                $modelAck->confirmed_by = $_SESSION['logged_user']['type'];
                $modelAck->save();
            }
        }
        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/shiftManagementForHospital/booking', array('id' => $post['staff_request_id']));
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actionconfirm($id, $staffId) {
        $sqlQuery = "SELECT `shift_start_datetime`, `shift_end_datetime`, `quantity_confirmed`, `quantity` FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $count = $command[0]['quantity_confirmed'];

        if ($command[0]['quantity_confirmed'] < $command[0]['quantity']) {
            $count = $count + 1;
            $modelBooking = new Booking;
            $modelBooking->staff_request_id = $id;
            $modelBooking->staff_id = $staffId;
            $modelBooking->confirmation_date = date("Y-m-d");
            $modelBooking->confirmation_time = date("H:i:s");
            $modelBooking->confirm_by_whom = $_SESSION['logged_user']['type'];
            $modelBooking->cancel_by_whom = '0';
            $modelBooking->cancellation_date = "0000-00-00";
            $modelBooking->cancellation_time = "00:00:00";
            $modelBooking->cancel_requested_by = "";

            if ($modelBooking->save()) {

                /*
                 * Start Confirmation Mail function
                 */
                $data = array();
                $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $id . "'";
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
                        ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $id)
                );
                $data = array(
                    "agent_user_id" => $_SESSION['logged_user']['id'],
                    "is_confirmed" => 'Y'
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_enquiry_ack', $data, 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $staffId, ':staff_request_id' => $id)
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
                }
            }
        }
        $ls_message = "";
        if ($command[0]['quantity_confirmed'] == $command[0]['quantity']) {
            $ls_message = "Sorry! Shift already fulfilled!";
        }
        $_SESSION['errorInAssign'] = $ls_message;
        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/shiftManagementForHospital/booking', array('id' => $id));
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actionagainconfirm($id, $staffId) {
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $count = $command[0]['quantity_confirmed'];

        $staffs = $this->getAvailableStaffAll($id, $command[0]['shift_start_datetime'], $command[0]['shift_end_datetime'], $command[0]['job_type_id'], $command[0]['hospital_unit_id']);
        $lf_flag = 0;
        foreach ($staffs as $record) {
            if ($record[0] == $staffId) {
                $sqlQueryForStaff = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $id . "' AND `staff_id` = " . $record[0];
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
                "confirm_by_whom" => $_SESSION['logged_user']['type'],
                "cancel_by_whom" => '0',
                "cancellation_date" => "0000-00-00",
                "cancellation_time" => "00:00:00",
                "cancel_requested_by" => ""
            );
            $update = Yii::app()->db->createCommand()
                    ->update('ams_booking', $data, 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $staffId, ':staff_request_id' => $id)
            );

            if ($update) {

                /*
                 * Start Confirmation Mail function
                 */
                $data = array();
                $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $id . "'";
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
                        ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $id)
                );
                $data = array(
                    "agent_user_id" => $_SESSION['logged_user']['id'],
                    "is_confirmed" => 'Y'
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_shift_enquiry_ack', $data, 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $staffId, ':staff_request_id' => $id)
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
                }
            }
        }

        $ls_message = "";
        if ($lf_flag == 0) {
            $ls_message = "Sorry! Staff already assigned for another shift!";
        } elseif ($command[0]['quantity_confirmed'] == $command[0]['quantity']) {
            $ls_message = "Sorry! Shift already fulfilled!";
        }
        $_SESSION['errorInAssign'] = $ls_message;

        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/shiftManagementForHospital/booking', array('id' => $id));
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actiondirectConfirmation() {
        if (isset($_POST['staff_ids'])) {
            $post = $_POST;
            for ($i = 0; $i < count($_POST['staff_ids']); $i++) {
                $sqlQuery = "SELECT `shift_start_datetime`, `shift_end_datetime`, `quantity_confirmed`, `quantity` FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = " . $post['staff_request_id'];
                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                $count = $command[0]['quantity_confirmed'];
                if ($command[0]['quantity_confirmed'] == $command[0]['quantity']) {
                    break;
                }

                $modelAck = new ShiftEnquiryAck;
                $modelAck->staff_request_id = $post['staff_request_id'];
                $modelAck->staff_id = $post['staff_ids'][$i];
                $modelAck->enquired_by = $post['enquired_by'];
                $modelAck->availability_confirmed_by_staff = 'Y';
                $modelAck->availability_confirmed_via = "By phone";
                $modelAck->confirmed_by = $_SESSION['logged_user']['type'];
                $modelAck->agent_user_id = $post['enquired_by'];
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
                        ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $post['staff_request_id'])
                );
                $modelBooking = new Booking;
                $modelBooking->staff_request_id = $post['staff_request_id'];
                $modelBooking->staff_id = $post['staff_ids'][$i];
                $modelBooking->confirmation_date = date("Y-m-d");
                $modelBooking->confirmation_time = date("H:i:s");
                $modelBooking->confirm_by_whom = $_SESSION['logged_user']['type'];
                $modelBooking->cancel_by_whom = '0';
                $modelBooking->cancellation_date = "0000-00-00";
                $modelBooking->cancellation_time = "00:00:00";
                $modelBooking->cancel_requested_by = "";

                if ($modelBooking->save()) {

                    /*
                     * Start Confirmation Mail function
                     */
                    $data = array();

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
                    $afterBookingNonAvailability->staff_id = $post['staff_ids'][$i];
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
        }
        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/shiftManagementForHospital/booking', array('id' => $post['staff_request_id']));
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actioncancel($id, $staffId) {
        $sqlQuery1 = "SELECT * FROM {{booking}} WHERE `staff_request_id` = '" . $id . "' AND `staff_id` = " . $staffId;
        $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();

        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/booking/cancel', array('id' => $command1['0']['booking_id'], 'staffRequestId' => $id));
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function getCancelAfterConfirmedShift($staffRequestId) {
        $staffs = array();
        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour,b.cancel_by_whom "
                . " FROM  {{booking}} b  "
                . " LEFT JOIN  {{shift_enquiry_ack}} ack  ON  b.staff_request_id=ack.staff_request_id"
                . " LEFT JOIN {{user}} usr  ON ack.staff_id=usr.id"
                . "  LEFT JOIN {{staff_registration}} stf ON usr.staff_id = stf.staff_id"
                . " WHERE  `availability_confirmed_by_staff` = 'Y' AND b.staff_id = ack.staff_id AND  b.staff_request_id = '" . $staffRequestId . "' AND b.cancel_by_whom != 0 ORDER BY stf.first_name";

        $rawData = Yii::app()->db->createCommand($sql); //or use ->queryAll(); in CArrayDataProvider
        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); //the count
        $dataProvider = new CSqlDataProvider($rawData, array(
            'keyField' => 'enquiry_id',
            'totalItemCount' => $count,
            'sort' => array(
                'attributes' => array(
                    'enquiry_id', 'staff_request_id', 'staff_id', 'enquired_by', 'availability_confirmed_by_staff', 'availability_confirmed_via', 'confirmed_by', 'agent_user_id', 'is_confirmed'
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        return $dataProvider;
    }

    public function getBookedStaff($id) {
        $staffs = array();
        $sql = "SELECT ack.*, stf.first_name, stf.mobile_no, stf.email, stf.max_allowed_hour FROM {{user}} usr, {{booking}} b, {{shift_enquiry_ack}} ack, {{staff_registration}} stf WHERE ack.staff_id=usr.id AND b.staff_request_id=ack.staff_request_id AND b.staff_id = ack.staff_id AND `availability_confirmed_by_staff` = 'Y' AND ack.is_confirmed = 'Y' AND usr.staff_id = stf.staff_id AND ack.staff_request_id = '" . $id . "' AND b.cancel_by_whom = 0 ORDER BY stf.first_name";
        $rawData = Yii::app()->db->createCommand($sql); //or use ->queryAll(); in CArrayDataProvider
        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); //the count
        $dataProvider = new CSqlDataProvider($rawData, array(
            'keyField' => 'enquiry_id',
            'totalItemCount' => $count,
            'sort' => array(
                'attributes' => array(
                    'enquiry_id', 'staff_request_id', 'staff_id', 'enquired_by', 'availability_confirmed_by_staff', 'availability_confirmed_via', 'confirmed_by', 'agent_user_id', 'is_confirmed'
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        return $dataProvider;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ShiftManagementForHospital;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ShiftManagementForHospital'])) {
            $post = $_POST;
//             print_r($post);die;
            for ($i = 0; $i < count($post['ward_id']); $i++) {

                $model = new ShiftManagementForHospital;

                $model->attributes = $_POST['ShiftManagementForHospital'];
                $model->ward_id = $post['ward_id'][$i];
                $model->job_type_id = $post['job_type_id'][$i];
                $model->quantity = $post['quantity'][$i];
                $model->notes = $post['notes'][$i];
                $model->request_accepted_by = $_SESSION['logged_user']['id'];

                $c = $i + 1;
                $model->shift_start_datetime = Utility::changeDateToMysql($post['shift_start_datetime_' . $c]);
                $model->shift_end_datetime = Utility::changeDateToMysql($post['shift_end_datetime_' . $c]);
                $model->requested_date = Utility::changeDateToMysql($model->requested_date);
                $model->status = "A";

                $sqlQueryForDuplicateEntry = "SELECT * FROM {{shift_management_for_hospital}} WHERE `hospital_unit_id` = '" . $model->hospital_unit_id . "' AND `ward_id` = '" . $model->ward_id . "' AND `job_type_id` = '" . $model->job_type_id . "' AND `shift_start_datetime` = '" . $model->shift_start_datetime . "' AND `shift_end_datetime` = '" . $model->shift_end_datetime . "'";
                $commandForDuplicateEntry = Yii::app()->db->createCommand($sqlQueryForDuplicateEntry)->queryAll();

                if (count($commandForDuplicateEntry) == 0) {
                    $model->save();
                } else {
                    $ls_adminUrl = Yii::app()->createUrl('admin/shiftManagementForHospital/update&id=' . $commandForDuplicateEntry[0]['staff_request_id']);
                    header('Location:' . $ls_adminUrl);
                    exit();
                }
            }
            $ls_adminUrl = Yii::app()->createUrl('admin/ShiftManagementForHospital/admin');
            header('Location:' . $ls_adminUrl);
            exit();
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $model = $this->loadModel($id);
        $model->shift_start_datetime = Utility::changeDateToUK($model->shift_start_datetime);
        $model->shift_end_datetime = Utility::changeDateToUK($model->shift_end_datetime);
        $model->requested_date = Utility::changeDateToUK($model->requested_date);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ShiftManagementForHospital'])) {
//            print_r($_POST);die;
            $model->attributes = $_POST['ShiftManagementForHospital'];
            $model->ward_id = $_POST['ShiftManagementForHospital']['ward_id'];
            $model->shift_start_datetime = Utility::changeDateToMysql($model->shift_start_datetime);
            $model->shift_end_datetime = Utility::changeDateToMysql($model->shift_end_datetime);
            $model->requested_date = Utility::changeDateToMysql($model->requested_date);
            $model->notes = $_POST['ShiftManagementForHospital']['notes'];
            if ($_POST['ShiftManagementForHospital']['status'] != "") {
                $model->status = $_POST['ShiftManagementForHospital']['status'];
            }

            if ($model->save()) {

                $this->redirect(array('view', 'id' => $model->staff_request_id));
            }
            $model->attributes = $_POST['ShiftManagementForHospital'];
        }


        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
//        if ($_SESSION[logged_user][type] != 'M' && $_SESSION[logged_user][type] != 'C') {
//            $this->loadModel($id)->delete();
//
//            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//            if (!isset($_GET['ajax']))
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//        }else {
        $data = array(
            "status" => 'Ar'
        );
        $update = Yii::app()->db->createCommand()
                ->update('ams_shift_management_for_hospital', $data, 'staff_request_id=:staff_request_id', array(':staff_request_id' => $id)
        );
        if ($update) {
            $sqlQuery = "SELECT * FROM {{booking}} WHERE `staff_request_id` = '" . $id . "' AND `cancel_by_whom` = 0";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

            foreach ($command as $la_value) {
                $li_staff_id = $la_value['staff_id'];
                $id = $la_value['booking_id'];
                $staffRequestId = $la_value['staff_request_id'];
                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                    $data = array(
                        "cancel_requested_by" => 'H',
                        "cancellation_date" => date("Y-m-d"),
                        "cancellation_time" => date("H:i:s"),
                        "cancel_by_whom" => $_SESSION['logged_user']['id']
                    );
                    $bookingUpdate = Yii::app()->db->createCommand()
                            ->update('ams_booking', $data, 'booking_id=:booking_id', array(':booking_id' => $id)
                    );

                    if ($bookingUpdate) {
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

                        $sqlQuery = "SELECT `non_availablility_id`, `staff_id` FROM {{non_availability_of_staff}} WHERE `staff_id` = '" . $li_staff_id . "' AND `start_date` = '" . $lv_shiftStartDate . "' AND `end_date` = '" . $lv_shiftEndDate . "' AND `start_time` = '" . $lv_shiftStartTime . "' AND `end_time` = '" . $lv_shiftEndTime . "' AND `already_booked` = 'Y'";
                        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                        $lv_nonAvailablilityId = $command[0]['non_availablility_id'];

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

                        $sqlQueryAll = "SELECT `hospital_unit`, `mobile`, h.address, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w, {{user}} u "
                                . "WHERE h.relevant_coordinator_id = u.id AND `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' "
                                . "AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
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
                    }
                
            }
        }
        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/ShiftManagementForHospital/admin');
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
//        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ShiftManagementForHospital');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ShiftManagementForHospital('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftManagementForHospital']))
            $model->attributes = $_GET['ShiftManagementForHospital'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminArchive() {
        $model = new ShiftManagementForHospital('search_archive');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftManagementForHospital']))
            $model->attributes = $_GET['ShiftManagementForHospital'];

        $this->render('admin_archive', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminSelf() {
        $model = new ShiftManagementForHospital('search_self');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftManagementForHospital']))
            $model->attributes = $_GET['ShiftManagementForHospital'];

        $this->render('admin_self', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.admin_historical_unfilled
     */
    public function actionAdminUnfilled() {
        $model = new ShiftManagementForHospital('search_unfilled');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftManagementForHospital']))
            $model->attributes = $_GET['ShiftManagementForHospital'];

        $this->render('admin_unfilled', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminHistoricalFilled() {
        $model = new ShiftManagementForHospital('search_historical_unfilled');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftManagementForHospital']))
            $model->attributes = $_GET['ShiftManagementForHospital'];

        $this->render('admin_historical_filled', array(
            'model' => $model,
        ));
    }

    public function actionSendSMSOrMail($id, $email, $mobile) {

        if ($email != "") {
            $sqlQueryForReminder = "SELECT s.staff_request_id, u.first_name, u.last_name, u.mobile, h.hospital_unit, h.email, h.contact_number, w.ward_name, j.job_type, s.quantity, s.quantity_confirmed, s.shift_start_datetime, s.shift_end_datetime FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{job_type}} j, {{ward}} w WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND s.staff_request_id = '" . $id . "' AND s.ward_id = w.ward_id AND s.job_type_id = j.job_type_id ORDER BY u.first_name";
            $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

            $data = array();
            $ls_staff_list = '';
            $i = 1;
            foreach ($commandForReminder AS $lv_reminder) {
                $data['staff_requirement'] = "Job type : " . $lv_reminder['job_type'] . "<br>Ward name : " . $lv_reminder['ward_name'] . "<br>Quantity : " . $lv_reminder['quantity'] . "<br>Shift start datetime : " . Utility::changeDateToUK($lv_reminder['shift_start_datetime']) . "<br>Shift end datetime : " . Utility::changeDateToUK($lv_reminder['shift_end_datetime']);
                $ls_staff_list.= $i++ . '. Name : <b>' . $lv_reminder["first_name"] . ' ' . $lv_reminder["last_name"] . '</b> <br>   Mobile : <b>' . $lv_reminder["mobile"] . '</b>.<br>';
            }
            $data['hospital_unit'] = $lv_reminder["hospital_unit"];
            $data['staff_request_id'] = $lv_reminder["staff_request_id"];
            $data['email'] = $lv_reminder["email"];
            $data['staff_list'] = $ls_staff_list;
            Utility::hospitalReminderMail($data);
        } elseif ($mobile != "") {
            $sqlQueryForReminder = "SELECT s.staff_request_id, u.first_name, u.last_name, u.mobile, h.hospital_unit, h.email, h.contact_number, w.ward_name, j.job_type, s.quantity, s.quantity_confirmed, s.shift_start_datetime, s.shift_end_datetime FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{job_type}} j, {{ward}} w WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND s.staff_request_id = '" . $id . "' AND s.ward_id = w.ward_id AND s.job_type_id = j.job_type_id ORDER BY u.first_name";
            $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

            $data = array();
            $ls_staff_list = '';
            $i = 1;
            foreach ($commandForReminder AS $lv_reminder) {
                $data['staff_requirement'] = "Job type : " . $lv_reminder['job_type'] . ", Ward name : " . $lv_reminder['ward_name'] . ", Quantity : " . $lv_reminder['quantity'] . ", Shift start datetime : " . Utility::changeDateToUK($lv_reminder['shift_start_datetime']) . ", Shift end datetime : " . Utility::changeDateToUK($lv_reminder['shift_end_datetime']);
                $ls_staff_list.= $i++ . '. Name : ' . $lv_reminder["first_name"] . ' ' . $lv_reminder["last_name"] . ', Mobile : ' . $lv_reminder["mobile"] . '. ';
            }
            $data['hospital_unit'] = $lv_reminder["hospital_unit"];
            $data['staff_request_id'] = $lv_reminder["staff_request_id"];
            $data['staff_requirement'];
            $data['email'] = $lv_reminder["email"];
            $data['mobile'] = $lv_reminder["contact_number"];
            $data['staff_list'] = $ls_staff_list;
            Utility::hospitalReminderSMS($data);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ShiftManagementForHospital the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ShiftManagementForHospital::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ShiftManagementForHospital $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'shift-management-for-hospital-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddMoreShift() {
        $model = new ShiftManagementForHospital;
        $this->renderPartial('add_more_shift', array('model' => $model));
    }

    /*
     */

    public function actionGetContactNumberForHospital() {
        $sqlQuery = "SELECT * FROM {{hospital_unit}} WHERE `hospital_unit_id`='" . $_POST['hospital_unit_id'] . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        echo $command[0]['contact_number'];
    }

    public function actionGetWardForHospital() {
        $sqlQueryForWard = "SELECT w.ward_id, w.ward_name FROM {{ward}} w, {{ward_hospital_unit_map}} wm, {{hospital_unit}} hu WHERE w.ward_id=wm.ward_id AND hu.hospital_unit_id=wm.hospital_unit_id AND hu.hospital_unit_id='" . $_POST['hospital_unit_id'] . "'";
        $commandForWard = Yii::app()->db->createCommand($sqlQueryForWard)->queryAll();
        $allWard = '';
        foreach ($commandForWard as $k => $lv_ward) {
            $allWard .=
                    '<option value="' . $lv_ward['ward_id'] . '">' . $lv_ward['ward_name'] . '</option>';
        }
        echo $allWard;
    }

    public function actionautocomplete() {
        $searchTerm = $_GET['term'];

        $sqlQueryForJobType = "SELECT * FROM {{job_type}} j WHERE j.job_type LIKE '%" . $searchTerm . "%' ORDER BY j.job_type ASC";
        $commandForJobType = Yii::app()->db->createCommand($sqlQueryForJobType)->queryAll();

//        print_r($commandForJobType);
        $data = array();
        foreach ($commandForJobType AS $lo_jobType) {
            $key = $lo_jobType['job_type_id'];
            $value = $lo_jobType['job_type'];
            $data[$key] = $value;
        }
        //return json data
        echo json_encode($data);
    }

    public function actionSendSMS($id, $staffId) {
        $data = array();
        $sqlQueryForReminder = "SELECT u.first_name, u.email, u.mobile, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} sr WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND u.staff_id = sr.staff_id AND sr.staff_status = 'A' AND s.staff_request_id = '" . $id . "' AND u.id = '" . $staffId . "'";
        $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

        $ls_reminder = '';
        foreach ($commandForReminder AS $lv_details) {
            $data['first_name'] = $lv_details['first_name'];
            $ls_reminder.= 'at ' . $lv_details["hospital_unit"] . ' on ' . Utility::changeDateToUK($lv_details["shift_start_datetime"]) . ' to ' . Utility::changeDateToUK($lv_details["shift_end_datetime"]);
        }
        $data['mobile'] = $lv_details['mobile'];
        $data['reminder'] = $ls_reminder;
        Utility::reminderSMS($data);

        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/ShiftManagementForHospital/booking&id=' . $id);
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actionvalueForBar() {
        $ld_today = date("Y-m-d");
        $ld_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 7 day"));
//        $command = Yii::app()->db->createCommand("SELECT `shift_start_datetime`, `request_accepted_by`, SUM(`quantity`), SUM(`quantity_confirmed`) FROM {{shift_management_for_hospital}} WHERE `request_accepted_by` = " . $_SESSION['logged_user']['id'] . " AND `shift_start_datetime` BETWEEN '" . $ld_today . "' AND '" . $ld_dateThreshold . "' GROUP BY `request_accepted_by`, `shift_start_datetime` ")->queryAll();
        $command = Yii::app()->db->createCommand("SELECT `shift_start_datetime`, `request_accepted_by`, `quantity`, `quantity_confirmed` FROM {{shift_management_for_hospital}} WHERE `request_accepted_by` = " . $_SESSION['logged_user']['id'] . " AND `shift_start_datetime` BETWEEN '" . $ld_today . "' AND '" . $ld_dateThreshold . "'")->queryAll();
        $i = 0;
        foreach ($command AS $la_value) {
            $command[$i]['shift_start_datetime'] = Utility::changeDateToUK($la_value['shift_start_datetime']);
            $command[$i++]['percentage'] = round(($la_value['quantity_confirmed'] / $la_value['quantity']) * 100, 2);
        }
        print json_encode($command);
    }

    public function actionSendEnquiryAll() {
//        print_r($_POST['staff_request_id']);
        if (isset($_POST['staff_request_id'])) {
            foreach ($_POST['staff_request_id'] as $la_staffRequestIdValue) {
                $sqlQueryForShiftDetails = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $la_staffRequestIdValue . "'";
                $commandForShiftDetails = Yii::app()->db->createCommand($sqlQueryForShiftDetails)->queryAll();
                foreach ($commandForShiftDetails as $la_shiftDetailsValue) {
                    $la_selectedStaff = array();
                    $la_allStaffs = array();
                    $j = 0;
                    $la_allStaffs = $this->getAvailableStaffAll($la_shiftDetailsValue['staff_request_id'], $la_shiftDetailsValue['shift_start_datetime'], $la_shiftDetailsValue['shift_end_datetime'], $la_shiftDetailsValue['job_type_id'], $la_shiftDetailsValue['hospital_unit_id']);
                    foreach ($la_allStaffs as $record) {
                        $sqlQueryForStaff = "SELECT * FROM {{shift_enquiry_ack}} WHERE `staff_request_id` = '" . $la_shiftDetailsValue['staff_request_id'] . "' AND `staff_id` = " . $record[0];
                        $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();
                        if (count($commandForStaff) == 0) {
                            $la_selectedStaff[$j++] = $record;
                        }
                    }
                    for ($i = 0; $i < count($la_selectedStaff); $i++) {
                        $modelAck = new ShiftEnquiryAck;
                        $modelAck->staff_request_id = $la_staffRequestIdValue;
                        $modelAck->staff_id = $la_selectedStaff[$i][0];
                        $modelAck->enquired_by = $_SESSION['logged_user']['id'];
                        $modelAck->confirmed_by = 'NA';
                        $modelAck->agent_user_id = $_SESSION['logged_user']['id'];
                        $modelAck->save();
                    }
                }
            }
            $staffRequestId = implode(",", $_POST['staff_request_id']);

            $sqlQueryForReminder = "SELECT u.first_name, u.mobile, u.email, j.job_type, w.ward_name, h.hospital_unit_id, h.hospital_unit, h.address, s.shift_start_datetime, s.shift_end_datetime "
                    . "FROM {{user}} u, {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{shift_enquiry_ack}} a, {{job_type}} j, {{ward}} w "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = a.staff_id AND s.staff_request_id = a.staff_request_id AND j.job_type_id = s.job_type_id "
                    . "AND s.ward_id = w.ward_id AND a.staff_request_id IN (" . $staffRequestId . ") ORDER BY s.shift_start_datetime";
            $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

            $sqlQueryForReminderEmail = "SELECT u.email FROM {{user}} u, {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{shift_enquiry_ack}} a "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = a.staff_id AND s.staff_request_id = a.staff_request_id "
                    . "AND a.staff_request_id IN (" . $staffRequestId . ") GROUP BY u.email ORDER BY s.shift_start_datetime";
            $commandForReminderEmail = Yii::app()->db->createCommand($sqlQueryForReminderEmail)->queryAll();

            $sqlQueryForReminderHospital = "SELECT h.hospital_unit FROM {{user}} u, {{shift_management_for_hospital}} s, {{hospital_unit}} h, {{shift_enquiry_ack}} a "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = a.staff_id AND s.staff_request_id = a.staff_request_id "
                    . "AND a.staff_request_id IN (" . $staffRequestId . ") GROUP BY h.hospital_unit ORDER BY s.shift_start_datetime";
            $commandForReminderHospital = Yii::app()->db->createCommand($sqlQueryForReminderHospital)->queryAll();

            foreach ($commandForReminderEmail AS $lv_email) {
                $data = array();
                $ls_mailReminder = '';
                $ls_smsReminder = '';
                foreach ($commandForReminder AS $lv_details) {
                    if ($lv_email['email'] == $lv_details['email']) {
                        $data['first_name'] = $lv_details['first_name'];
                        $data['email'] = $lv_email['email'];
                        $data['mobile'] = $lv_details['mobile'];

                        $sqlQueryCoordinator = "SELECT u.mobile FROM {{hospital_unit}} h, {{user}} u WHERE h.relevant_coordinator_id = u.id AND h.hospital_unit_id = '" . $lv_details['hospital_unit_id'] . "'";
                        $commandCoordinator = Yii::app()->db->createCommand($sqlQueryCoordinator)->queryAll();

                        $ls_mailReminder .= 'Hospital Name : <b>' . $lv_details["hospital_unit"] . '</b><br>'
                                . 'Address : <b>' . $lv_details["address"] . '</b><br>'
                                . 'Job Type : <b>' . $lv_details["job_type"] . '</b><br>'
                                . 'Ward Name : <b>' . $lv_details["ward_name"] . '</b><br>'
                                . 'Shift Duration : <b>' . Utility::changeDateToUK($lv_details["shift_start_datetime"]) . '</b> to <b>' . Utility::changeTimeFromDateToUK($lv_details["shift_end_datetime"]) . '</b><br>'
                                . 'Contact to : <b>' . $commandCoordinator[0]['mobile'] . '</b><br><br>';
                    }
                }

                foreach ($commandForReminderHospital AS $lv_hospitalDetails) {
                    $ls_prevHospitalName = $lv_hospitalDetails['hospital_unit'];
                    $ls_prevHospitalNameCount = 0;
                    foreach ($commandForReminder AS $lv_details) {
                        if (($lv_email['email'] == $lv_details['email']) && ($lv_hospitalDetails['hospital_unit'] == $lv_details['hospital_unit'])) {

                            if ($ls_prevHospitalNameCount != 1) {
                                $ls_prevHospitalNameCount = 1;
                                $ls_smsReminder .= 'at ' . $lv_details["hospital_unit"];
                            }
                            $ls_smsReminder .= ' on ' . Utility::changeDateToUK($lv_details["shift_start_datetime"]) . ' '
                                    . 'to ' . Utility::changeTimeFromDateToUK($lv_details["shift_end_datetime"]) . '; ';
                        }
                    }
                }

                $data['mailReminder'] = $ls_mailReminder;
                $data['smsReminder'] = $ls_smsReminder;

                Utility::enquiryToAllMail($data);
            }
        }

        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/ShiftManagementForHospital/admin');
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

}
