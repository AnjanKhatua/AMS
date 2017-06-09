<?php

class TimesheetController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'CheckDuplicate', 'CheckDuplicateShift', 'downloadTimesheet', 'downloadStaffTimesheet'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->layout = '//layouts/column4';

        $model = new Timesheet;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Timesheet'])) {
            $post = $_POST;
            if ($_POST['Timesheet']['staff_id'] != "") {
                $userEmail = $_POST['Timesheet']['staff_id'];
                $startValue = strrpos($userEmail, "(") + 1;
                $ls_email = substr($userEmail, $startValue, -1);
                $sqlQuery = "SELECT u.id FROM {{user}} u WHERE u.email = '" . $ls_email . "'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();
            } else {
                $model->addError('staff_id', 'Staff cannot be blank.');
            }
            $i = 0;
            $p = 1;
            $ls_msg = "";
            if ($_POST['Timesheet']['staff_id'] != "") {
                for ($i = 0; $i < count($post['Timesheet']['finance_job_type_id']); $i++) {
                    $flag = 0;
                    $la_finalResult = Utility::checkDuplicateShifts($command['id'], $post['Timesheet']['week_end_date'][$i]);
                    $ls_weekEndDateForError = "";

                    foreach ($la_finalResult as $key => $value) {
                        if (($la_finalResult[$key] != 0) && ($post['Timesheet'][$key][$i] != 0)) {
                            $flag = 1;
                        }
                    }

                    if ($flag == 1) {
                        if ($ls_msg == "") {
                            $ls_msg = "Duplicate Entry!! <br>Please note : <br>";
                        }
                        $ls_msg .= $p++ . ". Week End Date : " . Utility::changeDateToUK($post['Timesheet']['week_end_date'][$i]) . " ";

                        foreach ($la_finalResult as $key => $value) {
                            if (($la_finalResult[$key] != 0) && ($post['Timesheet'][$key][$i] != 0)) {
                                if ($ls_weekEndDateForError == "") {
                                    $ls_weekEndDateForError .= $key;
                                } else {
                                    $ls_weekEndDateForError .= ", " . $key;
                                }
                            }
                        }

                        if ($ls_weekEndDateForError != "") {
                            $ls_weekEndDateForError .= "<br>";
                        }

                        $ls_msg .= $ls_weekEndDateForError;
                    } else {
                        $model = new Timesheet;
                        if (isset($command['id']))
                            $model->staff_id = $command['id'];
                        $model->hospital_unit_id = $post['Timesheet']['hospital_unit_id'][$i];
                        $model->invoice_date = Utility::changeDateToMysql($post['Timesheet']['invoice_date']);
                        $model->week_end_date = $post['Timesheet']['week_end_date'][$i];
                        $model->finance_job_type_id = $post['Timesheet']['finance_job_type_id'][$i];
                        $model->monday = $post['Timesheet']['monday'][$i];
                        $model->tuesday = $post['Timesheet']['tuesday'][$i];
                        $model->wednesday = $post['Timesheet']['wednesday'][$i];
                        $model->thursday = $post['Timesheet']['thursday'][$i];
                        $model->friday = $post['Timesheet']['friday'][$i];
                        $model->saturday = $post['Timesheet']['saturday'][$i];
                        $model->sunday = $post['Timesheet']['sunday'][$i];
                        $model->exp = $post['Timesheet']['exp'][$i];
                        $model->note = $post['Timesheet']['note'][$i];

                        if ($model->monday == "") {
                            $model->monday = 0;
                        }
                        if ($model->tuesday == "") {
                            $model->tuesday = 0;
                        }
                        if ($model->wednesday == "") {
                            $model->wednesday = 0;
                        }
                        if ($model->thursday == "") {
                            $model->thursday = 0;
                        }
                        if ($model->friday == "") {
                            $model->friday = 0;
                        }
                        if ($model->saturday == "") {
                            $model->saturday = 0;
                        }
                        if ($model->sunday == "") {
                            $model->sunday = 0;
                        }
                        if ($model->exp == "") {
                            $model->exp = 0;
                        }

                        $sqlQueryForStaffRate = "SELECT s.rate FROM {{staff_job_type_rate_map}} s WHERE s.finance_job_type_id = '" . $model->finance_job_type_id . "' AND s.staff_id = '" . $model->staff_id . "'";
                        $commandForStaffRate = Yii::app()->db->createCommand($sqlQueryForStaffRate)->queryAll();

                        $sqlQueryForHospitalRate = "SELECT h.rate, h.pay_rate_for_staffs FROM {{hospital_job_type_rate_map}} h WHERE h.finance_job_type_id = '" . $model->finance_job_type_id . "' AND h.hospital_unit_id = '" . $model->hospital_unit_id . "'";
                        $commandForHospitalRate = Yii::app()->db->createCommand($sqlQueryForHospitalRate)->queryAll();

                        $lf_totalWorkedHours = $model->monday + $model->tuesday + $model->wednesday + $model->thursday + $model->friday + $model->saturday + $model->sunday;

                        $model->total_worked_hours = $lf_totalWorkedHours;

                        if (count($commandForStaffRate) != 0) {
                            $lf_totalAmountOfStaff = ($model->total_worked_hours * $commandForStaffRate[0]['rate']);
                        } else {
                            $lf_totalAmountOfStaff = ($model->total_worked_hours * $commandForHospitalRate[0]['pay_rate_for_staffs']);
                        }

                        $model->total_amount_of_staff = $lf_totalAmountOfStaff + $model->exp;
                        $model->total_amount_of_hospital = $model->total_worked_hours * $commandForHospitalRate[0]['rate'] + $model->exp;


                        $model->save();
                    }
                }
                if ($ls_msg != "") {
                    if ($p == 2) {
                        $ls_msg .= "above record has not inserted in the database.";
                    } else {
                        $ls_msg .= "above records has not inserted in the database.";
                    }
                    $_SESSION['errorMsgForTimesheet'] = $ls_msg;
                }

                if ($model->staff_id != "") {
                    $sqlQuery = "SELECT week_end_date, SUM(total_amount_of_staff) FROM {{timesheet}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.invoice_date = '" . $model->invoice_date . "' GROUP BY t.week_end_date";
                    $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

                    foreach ($command as $li_value) {
                        $li_trainingDeductionAmount = 00.00;

                        $sqlQueryForGetTrainingDeduction = "SELECT * FROM {{timesheet_training_deduction_week}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.week_end_date ='" . $li_value['week_end_date'] . "'";
                        $commandForGetTrainingDeduction = Yii::app()->db->createCommand($sqlQueryForGetTrainingDeduction)->queryAll();

                        if (count($commandForGetTrainingDeduction) == 0) {
                            $sqlQueryForTrainingDeduction = "SELECT * FROM {{training_details}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.remaining_amount > 0";
                            $commandForTrainingDeduction = Yii::app()->db->createCommand($sqlQueryForTrainingDeduction)->queryAll();

                            $li_amount = 0;
                            foreach ($commandForTrainingDeduction as $value) {
                                if ($value['remaining_amount'] > $value['deduction_amount']) {
                                    $li_amount = $value['deduction_amount'];
                                } else {
                                    $li_amount = $value['remaining_amount'];
                                }
                                $li_trainingDeductionAmount = $li_trainingDeductionAmount + $li_amount;
                            }

                            $weekModel = new TimesheetTrainingDeductionWeek;
                            $weekModel->staff_id = $model->staff_id;
                            $weekModel->invoice_date = $model->invoice_date;
                            $weekModel->week_end_date = $li_value['week_end_date'];
                            $weekModel->apply_status = 'N';
                            $weekModel->save();
                        }

                        if ((count($commandForGetTrainingDeduction) != 0) && ($commandForGetTrainingDeduction[0]['apply_status'] == 'N')) {
                            $sqlQueryForTimesheetPayment = "SELECT * FROM {{timesheet_payment_details_for_staff}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.week_end_date ='" . $li_value['week_end_date'] . "' AND t.invoice_date = '" . $model->invoice_date . "'";
                            $commandForTimesheetPayment = Yii::app()->db->createCommand($sqlQueryForTimesheetPayment)->queryAll();
                            $data = array(
                                "total_amount" => $li_value['SUM(total_amount_of_staff)']
                            );
                            $update = Yii::app()->db->createCommand()
                                    ->update('ams_timesheet_payment_details_for_staff', $data, 'id=:id', array(':id' => $commandForTimesheetPayment[0]['id'])
                            );
                        } else {
                            $staffModel = new TimesheetPaymentDetailsForStaff;
                            $staffModel->staff_id = $model->staff_id;
                            $staffModel->invoice_date = $model->invoice_date;
                            $staffModel->week_end_date = $li_value['week_end_date'];
                            $staffModel->total_amount = $li_value['SUM(total_amount_of_staff)'];
                            $staffModel->training_deduction_amount = $li_trainingDeductionAmount;
                            $staffModel->net_amount = 0;
                            $staffModel->training_deduction_apply = 'N';
                            $staffModel->paid_status = 'N';
                            $staffModel->save();
                        }
                    }
                }

                if ((count($post['Timesheet']['finance_job_type_id']) == $i)) {
                    $ls_adminUrl = Yii::app()->createUrl('finance/Timesheet/admin');
                    header('Location:' . $ls_adminUrl);
                    exit();
                }
            }
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
        $li_totalAmountOfStaff = $model->total_amount_of_staff;
        $li_invoiceDate = $model->invoice_date;
        $model->invoice_date = Utility::changeDateToUK($model->invoice_date);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Timesheet'])) {
//            $model->attributes = $_POST['Timesheet'];
            $post = $_POST;
            if ($_POST['Timesheet']['staff_id'] != "") {
                $userEmail = $_POST['Timesheet']['staff_id'];
                $startValue = strrpos($userEmail, "(") + 1;
                $ls_email = substr($userEmail, $startValue, -1);
                $sqlQuery = "SELECT u.id FROM {{user}} u WHERE u.email = '" . $ls_email . "'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();
            } else {
                $model->addError('staff_id', 'Staff cannot be blank.');
            }

            $flag = 0;
            $la_finalResult = Utility::checkDuplicateShiftsInUpdate($command['id'], $post['Timesheet']['week_end_date'], $id);

            foreach ($la_finalResult as $key => $value) {
                if (($la_finalResult[$key] != 0) && ($post['Timesheet'][$key] != 0))
                    $model->addError($key, 'Duplicate Entry!! Already insert ' . $key . ' in to a timesheet.');
            }

            $i = 0;
            if ($_POST['Timesheet']['staff_id'] != "") {
                if (isset($command['id']))
                    $model->staff_id = $command['id'];
                $model->hospital_unit_id = $post['Timesheet']['hospital_unit_id'];
                $model->invoice_date = Utility::changeDateToMysql($post['Timesheet']['invoice_date']);
                $model->week_end_date = $post['Timesheet']['week_end_date'];
                $model->finance_job_type_id = $post['Timesheet']['finance_job_type_id'];
                $model->monday = $post['Timesheet']['monday'];
                $model->tuesday = $post['Timesheet']['tuesday'];
                $model->wednesday = $post['Timesheet']['wednesday'];
                $model->thursday = $post['Timesheet']['thursday'];
                $model->friday = $post['Timesheet']['friday'];
                $model->saturday = $post['Timesheet']['saturday'];
                $model->sunday = $post['Timesheet']['sunday'];
                $model->exp = $post['Timesheet']['exp'];
                $model->note = $post['Timesheet']['note'];

                if ($model->monday == "") {
                    $model->monday = 0;
                }
                if ($model->tuesday == "") {
                    $model->tuesday = 0;
                }
                if ($model->wednesday == "") {
                    $model->wednesday = 0;
                }
                if ($model->thursday == "") {
                    $model->thursday = 0;
                }
                if ($model->friday == "") {
                    $model->friday = 0;
                }
                if ($model->saturday == "") {
                    $model->saturday = 0;
                }
                if ($model->sunday == "") {
                    $model->sunday = 0;
                }
                if ($model->exp == "") {
                    $model->exp = 0;
                }

                $sqlQueryForStaffRate = "SELECT s.rate FROM {{staff_job_type_rate_map}} s WHERE s.finance_job_type_id = '" . $model->finance_job_type_id . "' AND s.staff_id = '" . $model->staff_id . "'";
                $commandForStaffRate = Yii::app()->db->createCommand($sqlQueryForStaffRate)->queryAll();

                $sqlQueryForHospitalRate = "SELECT h.rate, h.pay_rate_for_staffs FROM {{hospital_job_type_rate_map}} h WHERE h.finance_job_type_id = '" . $model->finance_job_type_id . "' AND h.hospital_unit_id = '" . $model->hospital_unit_id . "'";
                $commandForHospitalRate = Yii::app()->db->createCommand($sqlQueryForHospitalRate)->queryAll();

                $lf_totalWorkedHours = $model->monday + $model->tuesday + $model->wednesday + $model->thursday + $model->friday + $model->saturday + $model->sunday;

                $model->total_worked_hours = $lf_totalWorkedHours;

                if (count($commandForStaffRate) != 0) {
                    $lf_totalAmountOfStaff = ($model->total_worked_hours * $commandForStaffRate[0]['rate']);
                } else {
                    $lf_totalAmountOfStaff = ($model->total_worked_hours * $commandForHospitalRate[0]['pay_rate_for_staffs']);
                }

                $model->total_amount_of_staff = $lf_totalAmountOfStaff + $model->exp;
                $model->total_amount_of_hospital = $model->total_worked_hours * $commandForHospitalRate[0]['rate'] + $model->exp;



                if ((count($model->getErrors()) == 0) && $model->save()) {
                    if ($li_totalAmountOfStaff != $model->total_amount_of_staff) {
                        $sqlQueryForGetTotalAmount = "SELECT SUM(total_amount_of_staff) FROM {{timesheet}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.invoice_date = '" . $model->invoice_date . "' AND t.week_end_date = '" . $model->week_end_date . "' GROUP BY t.week_end_date";
                        $commandForGetTotalAmount = Yii::app()->db->createCommand($sqlQueryForGetTotalAmount)->queryAll();

                        $sqlQueryForTimesheetPayment = "SELECT * FROM {{timesheet_payment_details_for_staff}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.week_end_date ='" . $model->week_end_date . "' AND t.invoice_date = '" . $model->invoice_date . "'";
                        $commandForTimesheetPayment = Yii::app()->db->createCommand($sqlQueryForTimesheetPayment)->queryAll();
                        $data = array(
                            "total_amount" => $commandForGetTotalAmount[0]['SUM(total_amount_of_staff)']
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_timesheet_payment_details_for_staff', $data, 'id=:id', array(':id' => $commandForTimesheetPayment[0]['id'])
                        );
                    } else {
                        $sqlQueryForGetTotalAmount = "SELECT SUM(total_amount_of_staff) FROM {{timesheet}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.invoice_date = '" . $model->invoice_date . "' AND t.week_end_date = '" . $model->week_end_date . "' GROUP BY t.week_end_date";
                        $commandForGetTotalAmount = Yii::app()->db->createCommand($sqlQueryForGetTotalAmount)->queryAll();

                        $sqlQueryForTimesheetPayment = "SELECT * FROM {{timesheet_payment_details_for_staff}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.week_end_date ='" . $model->week_end_date . "' AND t.invoice_date = '" . $li_invoiceDate . "'";
                        $commandForTimesheetPayment = Yii::app()->db->createCommand($sqlQueryForTimesheetPayment)->queryAll();
                        $data = array(
                            "invoice_date" => $model->invoice_date,
                            "total_amount" => $commandForGetTotalAmount[0]['SUM(total_amount_of_staff)']
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_timesheet_payment_details_for_staff', $data, 'id=:id', array(':id' => $commandForTimesheetPayment[0]['id'])
                        );
                        
                        $sqlQueryForTimesheetTrainingDeductionWeek = "SELECT * FROM {{timesheet_training_deduction_week}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.week_end_date ='" . $model->week_end_date . "' AND t.invoice_date = '" . $li_invoiceDate . "'";
                        $commandForTimesheetTrainingDeductionWeek = Yii::app()->db->createCommand($sqlQueryForTimesheetTrainingDeductionWeek)->queryAll();
                        $data = array(
                            "invoice_date" => $model->invoice_date
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_timesheet_training_deduction_week', $data, 'id=:id', array(':id' => $commandForTimesheetTrainingDeductionWeek[0]['id'])
                        );
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
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
        $model = $this->loadModel($id);
        $li_totalAmountOfStaff = $model->total_amount_of_staff;

        $sqlQueryForTimesheetPayment = "SELECT * FROM {{timesheet_payment_details_for_staff}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.week_end_date ='" . $model->week_end_date . "' AND t.invoice_date = '" . $model->invoice_date . "'";
        $commandForTimesheetPayment = Yii::app()->db->createCommand($sqlQueryForTimesheetPayment)->queryAll();

        $sqlQueryForTimesheetPaymentApply = "SELECT * FROM {{timesheet_training_deduction_week}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.week_end_date ='" . $model->week_end_date . "' AND t.invoice_date = '" . $model->invoice_date . "'";
        $commandForTimesheetPaymentApply = Yii::app()->db->createCommand($sqlQueryForTimesheetPaymentApply)->queryAll();

        $li_remainingAmount = $commandForTimesheetPayment[0]['total_amount'] - $li_totalAmountOfStaff;
        if ($li_remainingAmount != 0) {
            $data = array(
                "total_amount" => $li_remainingAmount
            );
            $update = Yii::app()->db->createCommand()
                    ->update('ams_timesheet_payment_details_for_staff', $data, 'id=:id', array(':id' => $commandForTimesheetPayment[0]['id'])
            );
        } else {
            Yii::app()->db->createCommand()->delete('ams_timesheet_payment_details_for_staff', 'id =' . $commandForTimesheetPayment[0]['id']);
            Yii::app()->db->createCommand()->delete('ams_timesheet_training_deduction_week', 'id =' . $commandForTimesheetPaymentApply[0]['id']);
        }


        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Timesheet');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column4';
        $model = new Timesheet('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Timesheet']))
            $model->attributes = $_GET['Timesheet'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionCheckDuplicate() {
        $ls_staff = $_POST['staffId'];
        $ld_invoiceDate = Utility::changeDateToMysql($_POST['invoiceDate']);

        $startValue = strrpos($ls_staff, "(") + 1;
        $ls_email = substr($ls_staff, $startValue, -1);

        $sqlQuery = "SELECT u.id FROM {{user}} u WHERE u.email = '" . $ls_email . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();
        $li_staff_id = $command['id'];

        $sqlQueryForCheck = "SELECT * FROM {{timesheet_training_deduction_week}} t WHERE t.staff_id = '" . $li_staff_id . "' AND t.invoice_date = '" . $ld_invoiceDate . "' AND t.apply_status = 'Y' ";
        $commandForCheck = Yii::app()->db->createCommand($sqlQueryForCheck)->queryAll();
        $ls_msg = "";
        if (count($commandForCheck) != 0) {
            $ls_msg = "Invoice has been already generated for this staff! Please try another day!";
        }
        echo $ls_msg;
    }

    public function actionCheckDuplicateShift() {
        $ls_staff = $_POST['staffId'];

        $startValue = strrpos($ls_staff, "(") + 1;
        $ls_email = substr($ls_staff, $startValue, -1);

        $sqlQuery = "SELECT u.id FROM {{user}} u WHERE u.email = '" . $ls_email . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();

        $li_staff_id = $command['id'];
        $ld_weekEndDate = Utility::changeDateToMysql($_POST['weekEndDate']);

        $la_finalResult = Utility::checkDuplicateShifts($li_staff_id, $ld_weekEndDate);
        print_r(json_encode($la_finalResult));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Timesheet the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Timesheet::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actiondownloadTimesheet() {
        $model = new Timesheet;

        $this->render('downloadTimesheet', array(
            'model' => $model,
        ));
    }

    public function actiondownloadStaffTimesheet() {
        $weekEndDate = $_POST['weekEndDate'];
        $ls_sqlForTimesheetList = "SELECT t.id, t.timesheet_name,u.email, t.week_end_date FROM {{uploaded_timesheet_by_staff}} t, {{user}} u WHERE t.staff_id = u.id AND t.week_end_date = '" . $weekEndDate . "'";
        $la_resultForTimesheetList = Yii::app()->db->createCommand($ls_sqlForTimesheetList)->queryAll();

        $destdir = Yii::app()->baseUrl . '/staffTimesheet/';
        $i = 1;
        $ls_result .= '<table id="mainTable" width="100%">';
        $ls_result .= '<tr>';
        $ls_result .= '<th>Id</th>';
        $ls_result .= '<th>Timesheet Upload Id</th>';
        $ls_result .= '<th>Email</th>';
        $ls_result .= '<th>Week end date</th>';
        $ls_result .= '<th>Timesheet</th>';
        $ls_result .= '</tr>';
        if (count($la_resultForTimesheetList) != 0) {
            foreach ($la_resultForTimesheetList as $key => $value) {
                $ls_result .= '<tr>';
                $ls_result .= '<td>' . $i++ . '</td>';
                $ls_result .= '<td>' . $value["id"] . '</td>';
                $ls_result .= '<td>' . $value["email"] . '</td>';
                $ls_result .= '<td>' . Utility::changeDateToUK($value["week_end_date"]) . '</td>';
                $ls_result .= '<td><a href=' . $destdir . $value["timesheet_name"] . ' download>Download</a></td>';
                $ls_result .= '</tr>';
            }
        } else {
            $ls_result .= '<tr>';
            $ls_result .= '<td colspan = "6" style = "color : red">No timesheet found in this week!!</td>';
            $ls_result .= '</tr>';
        }
        $ls_result .= '</table>';
//        print_r($la_resultForPaymentList);
        echo $ls_result;
    }

    /**
     * Performs the AJAX validation.
     * @param Timesheet $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'timesheet-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
