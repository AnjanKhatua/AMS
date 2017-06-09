<?php

class TimesheetPaymentDetailsForStaffController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'generateInvoice', 'getStaffPaymentDetails', 'trainingDeduction', 'exportAllInvoice', 'ExportGenerateInvoice', 'ExportGenerateInvoiceBeforeDeduction', 'makePayment', 'makePaymentForStaff', 'getStaffDetailsForPayment', 'ExportGenerateInvoiceForHospital'),
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
        $model = new TimesheetPaymentDetailsForStaff;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TimesheetPaymentDetailsForStaff'])) {
            $model->attributes = $_POST['TimesheetPaymentDetailsForStaff'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TimesheetPaymentDetailsForStaff'])) {
            $model->attributes = $_POST['TimesheetPaymentDetailsForStaff'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('TimesheetPaymentDetailsForStaff');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actiongenerateInvoice() {
        $model = new TimesheetPaymentDetailsForStaff;

        $this->render('generateInvoice', array(
            'model' => $model,
        ));
    }

    public function actiongetStaffPaymentDetails() {
        $invoiceDate = $_POST['invoiceDate'];
        $ls_sqlForPaymentList = "SELECT u.email, t.id, t.staff_id, t.invoice_date, t.week_end_date, t.total_amount, t.training_deduction_amount FROM {{timesheet_payment_details_for_staff}} t, {{timesheet_training_deduction_week}} td, {{user}} u WHERE t.staff_id = u.id AND td.staff_id = u.id AND t.invoice_date = td.invoice_date AND t.week_end_date = td.week_end_date AND t.invoice_date = '" . $invoiceDate . "' AND td.apply_status = 'N'";
        $la_resultForPaymentList = Yii::app()->db->createCommand($ls_sqlForPaymentList)->queryAll();

        $i = 0;
        $ls_result .= '<table id="mainTable" width="100%">';
        $ls_result .= '<tr>';
        $ls_result .= '<th>Id</th>';
        $ls_result .= '<th>Email</th>';
        $ls_result .= '<th>Invoice date</th>';
        $ls_result .= '<th>Week end date</th>';
        $ls_result .= '<th>Total amount</th>';
        $ls_result .= '<th>Training deduction</th>';
        $ls_result .= '</tr>';
        foreach ($la_resultForPaymentList as $key => $value) {
            $ls_result .= '<tr>';
            $ls_result .= '<td><input type = "hidden" name = "' . $i . '[id]" value = "' . $value["id"] . '">' . $value["id"] . '.</td>';
            $ls_result .= '<td>' . $value["email"] . '</td>';
            $ls_result .= '<td>' . Utility::changeDateToUK($value["invoice_date"]) . '</td>';
            $ls_result .= '<td><input type = "hidden" name = "' . $i . '[week_end_date]" value = "' . $value["week_end_date"] . '">' . Utility::changeDateToUK($value["week_end_date"]) . '</td>';
            $ls_result .= '<td>' . $value["total_amount"] . '</td>';
            $ls_result .= '<td><input type = "text" name = "' . $i++ . '[training_deduction_amount]" value = "' . $value["training_deduction_amount"] . '"></td>';
            $ls_result .= '</tr>';
        }
        $ls_result .= '</table>';
//        print_r($la_resultForPaymentList);
        echo $ls_result;
    }

    public function actiontrainingDeduction() {
        $post = $_POST;
        $count = count($post);
        $la_errorArray = array();
        $j = 0;
        $ld_invoiceDate = "";
        for ($i = 0; $i < $count; $i++) {
            $ls_sqlForGetRemainingAmount = "SELECT * FROM {{timesheet_payment_details_for_staff}} t WHERE t.id = '" . $post[$i]['id'] . "'";
            $la_resultForGetRemainingAmount = Yii::app()->db->createCommand($ls_sqlForGetRemainingAmount)->queryAll();

            $li_staffId = $la_resultForGetRemainingAmount[0]['staff_id'];
            $li_getPaymentAmount = $post[$i]['training_deduction_amount'];

            $sqlQueryForTrainingDeduction = "SELECT * FROM {{training_details}} t WHERE t.staff_id ='" . $la_resultForGetRemainingAmount[0]['staff_id'] . "' AND t.remaining_amount > 0 ORDER BY t.id";
            $commandForTrainingDeduction = Yii::app()->db->createCommand($sqlQueryForTrainingDeduction)->queryAll();

            $li_amounts = 0;
            foreach ($commandForTrainingDeduction as $value) {
                $li_amounts += $value['remaining_amount'];
            }

            if ($li_amounts >= $post[$i]['training_deduction_amount']) {
                if (count($la_resultForGetRemainingAmount) != 0) {
                    if ($la_resultForGetRemainingAmount[0]['training_deduction_amount'] == $post[$i]['training_deduction_amount']) {

                        $li_amount = 0;
                        foreach ($commandForTrainingDeduction as $value) {
                            $ld_invoiceDate = $value['fees_paid_date'];
                            if ($ld_invoiceDate == "") {
                                $ld_invoiceDate = Utility::changeDateToUK($post[$i]['week_end_date']);
                            } else {
                                $ld_invoiceDate .= ", " . Utility::changeDateToUK($post[$i]['week_end_date']);
                            }
                            if ($value['remaining_amount'] > $value['deduction_amount']) {
                                $li_amount = $value['remaining_amount'] - $value['deduction_amount'];
                                $data = array(
                                    "fees_paid_date" => $ld_invoiceDate,
                                    "remaining_amount" => $li_amount
                                );
                                $update = Yii::app()->db->createCommand()
                                        ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                                );
                            } else {
                                $li_amount = $value['remaining_amount'] - $value['remaining_amount'];
                                $data = array(
                                    "fees_paid_date" => $ld_invoiceDate,
                                    "remaining_amount" => $li_amount
                                );
                                $update = Yii::app()->db->createCommand()
                                        ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                                );
                            }
                        }
                    } elseif ($la_resultForGetRemainingAmount[0]['training_deduction_amount'] > $post[$i]['training_deduction_amount']) {

                        $li_amount = 0;
                        foreach ($commandForTrainingDeduction as $value) {
                            $ld_invoiceDate = $value['fees_paid_date'];
                            if ($ld_invoiceDate == "") {
                                $ld_invoiceDate = Utility::changeDateToUK($post[$i]['week_end_date']);
                            } else {
                                $ld_invoiceDate .= ", " . Utility::changeDateToUK($post[$i]['week_end_date']);
                            }
                            if ($value['remaining_amount'] > $value['deduction_amount']) {
                                if ($li_getPaymentAmount > $value['deduction_amount']) {
                                    $li_getPaymentAmount = $li_getPaymentAmount - $value['deduction_amount'];
                                    $li_amount = $value['remaining_amount'] - $value['deduction_amount'];
                                } else {
                                    $li_amount = $value['remaining_amount'] - $li_getPaymentAmount;
                                    $li_getPaymentAmount = $li_getPaymentAmount - $li_getPaymentAmount;
                                }
                                $data = array(
                                    "fees_paid_date" => $ld_invoiceDate,
                                    "remaining_amount" => $li_amount
                                );
                                $update = Yii::app()->db->createCommand()
                                        ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                                );
                            } else {
                                if ($li_getPaymentAmount > $value['remaining_amount']) {
                                    $li_getPaymentAmount = $li_getPaymentAmount - $value['remaining_amount'];
                                    $li_amount = $value['remaining_amount'] - $value['remaining_amount'];
                                } else {
                                    $li_amount = $value['remaining_amount'] - $li_getPaymentAmount;
                                    $li_getPaymentAmount = $li_getPaymentAmount - $li_getPaymentAmount;
                                }
                                $data = array(
                                    "fees_paid_date" => $ld_invoiceDate,
                                    "remaining_amount" => $li_amount
                                );
                                $update = Yii::app()->db->createCommand()
                                        ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                                );
                            }
                        }
                    } elseif ($la_resultForGetRemainingAmount[0]['training_deduction_amount'] < $post[$i]['training_deduction_amount']) {

                        while ($li_getPaymentAmount > 0) {
                            $sqlQueryForTrainingDeductions = "SELECT * FROM {{training_details}} t WHERE t.staff_id ='" . $la_resultForGetRemainingAmount[0]['staff_id'] . "' AND t.remaining_amount > 0 ORDER BY t.id";
                            $commandForTrainingDeductions = Yii::app()->db->createCommand($sqlQueryForTrainingDeductions)->queryAll();
                            $li_amount = 0;
                            foreach ($commandForTrainingDeductions as $value) {
                                $ld_invoiceDate = $value['fees_paid_date'];
                                if ($ld_invoiceDate == "") {
                                    $ld_invoiceDate = Utility::changeDateToUK($post[$i]['week_end_date']);
                                } else {
                                    $ld_invoiceDate .= ", " . Utility::changeDateToUK($post[$i]['week_end_date']);
                                }
                                if ($value['remaining_amount'] > $value['deduction_amount']) {
                                    if ($li_getPaymentAmount > $value['deduction_amount']) {
                                        $li_getPaymentAmount = $li_getPaymentAmount - $value['deduction_amount'];
                                        $li_amount = $value['remaining_amount'] - $value['deduction_amount'];
                                    } else {
                                        $li_amount = $value['remaining_amount'] - $li_getPaymentAmount;
                                        $li_getPaymentAmount = $li_getPaymentAmount - $li_getPaymentAmount;
                                    }
                                    $data = array(
                                        "fees_paid_date" => $ld_invoiceDate,
                                        "remaining_amount" => $li_amount
                                    );
                                    $update = Yii::app()->db->createCommand()
                                            ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                                    );
//                                    echo $li_amount;
//                                    echo '<br>';
                                } else {
                                    if ($li_getPaymentAmount > $value['remaining_amount']) {
                                        $li_getPaymentAmount = $li_getPaymentAmount - $value['remaining_amount'];
                                        $li_amount = $value['remaining_amount'] - $value['remaining_amount'];
                                    } else {
                                        $li_amount = $value['remaining_amount'] - $li_getPaymentAmount;
                                        $li_getPaymentAmount = $li_getPaymentAmount - $li_getPaymentAmount;
                                    }
                                    $data = array(
                                        "fees_paid_date" => $ld_invoiceDate,
                                        "remaining_amount" => $li_amount
                                    );
                                    $update = Yii::app()->db->createCommand()
                                            ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                                    );
                                }
                            }
                        }
                    }
                    $data = array(
                        "training_deduction_apply" => 'Y',
                        "training_deduction_amount" => $post[$i]['training_deduction_amount'],
                        "net_amount" => $la_resultForGetRemainingAmount[0]['total_amount'] - $post[$i]['training_deduction_amount']
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_timesheet_payment_details_for_staff', $data, 'id=:id', array(':id' => $la_resultForGetRemainingAmount[0]['id'])
                    );

                    $data = array(
                        "apply_status" => 'Y'
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_timesheet_training_deduction_week', $data, 'staff_id=:staff_id and invoice_date=:invoice_date and week_end_date=:week_end_date', array(':staff_id' => $la_resultForGetRemainingAmount[0]['staff_id'], ':invoice_date' => $la_resultForGetRemainingAmount[0]['invoice_date'], ':week_end_date' => $la_resultForGetRemainingAmount[0]['week_end_date'])
                    );
                }
            } else {
                $la_errorArray[$j++] = $post[$i]['id'];
            }
        }
        $ls_errorMessage = "";
        if ((isset($la_errorArray)) && count($la_errorArray) > 0) {
            $ls_errorMessage = "Please enter correct amount for following id's : ";
            foreach ($la_errorArray as $k => $value) {
                if ($k == 0)
                    $ls_errorMessage .= $value;
                else
                    $ls_errorMessage .= ", " . $value;
            }
        }
        $_SESSION['errorMsg'] = $ls_errorMessage;
        $ls_staffUpdatePageUrl = YII::app()->createUrl('finance/TimesheetPaymentDetailsForStaff/generateInvoice');
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actionmakePayment() {
        $model = new TimesheetPaymentDetailsForStaff;

        $this->render('makePayment', array(
            'model' => $model,
        ));
    }

    public function actiongetStaffDetailsForPayment() {
        $invoiceDate = $_POST['invoiceDate'];
        $ls_sqlForPaymentList = "SELECT u.email, t.id, t.staff_id, t.invoice_date, t.week_end_date, t.total_amount, t.training_deduction_amount, t.net_amount "
                . "FROM {{timesheet_payment_details_for_staff}} t, {{timesheet_training_deduction_week}} td, {{user}} u "
                . "WHERE t.staff_id = u.id AND td.staff_id = u.id AND t.invoice_date = td.invoice_date AND t.week_end_date = td.week_end_date AND "
                . "t.invoice_date = '" . $invoiceDate . "' AND td.apply_status = 'Y' AND t.paid_status = 'N'";
        $la_resultForPaymentList = Yii::app()->db->createCommand($ls_sqlForPaymentList)->queryAll();

        $i = 0;
        $ls_result .= '<table id="mainTable" width="100%">';
        $ls_result .= '<tr>';
        $ls_result .= '<th>Id</th>';
        $ls_result .= '<th>Email</th>';
        $ls_result .= '<th>Invoice date</th>';
        $ls_result .= '<th>Week end date</th>';
        $ls_result .= '<th>Total amount</th>';
        $ls_result .= '<th>Training deduction</th>';
        $ls_result .= '<th>Net amount</th>';
        $ls_result .= '</tr>';
        foreach ($la_resultForPaymentList as $key => $value) {
            $ls_result .= '<tr>';
            $ls_result .= '<td><input type = "hidden" name = "' . $i++ . '[id]" value = "' . $value["id"] . '">' . $value["id"] . '.</td>';
            $ls_result .= '<td>' . $value["email"] . '</td>';
            $ls_result .= '<td>' . Utility::changeDateToUK($value["invoice_date"]) . '</td>';
            $ls_result .= '<td>' . Utility::changeDateToUK($value["week_end_date"]) . '</td>';
            $ls_result .= '<td>' . $value["total_amount"] . '</td>';
            $ls_result .= '<td>' . $value["training_deduction_amount"] . '</td>';
            $ls_result .= '<td>' . $value["net_amount"] . '</td>';
            $ls_result .= '</tr>';
        }
        $ls_result .= '</table>';
//        print_r($la_resultForPaymentList);
        echo $ls_result;
    }

    public function actionmakePaymentForStaff() {
        $post = $_POST;
        $count = count($post);
        foreach ($post as $la_values) {
            $sqlQueryForGetShiftDetails = "SELECT td.id, td.staff_id, td.week_end_date, td.invoice_date FROM {{timesheet_payment_details_for_staff}} td WHERE td.id = '" . $la_values['id'] . "' AND td.paid_status = 'N'";
            $commandForGetShiftDetails = Yii::app()->db->createCommand($sqlQueryForGetShiftDetails)->queryAll();

            foreach ($commandForGetShiftDetails as $la_shiftDetailsValue) {
//                $sqlQuery = "SELECT t.id, hr.hospital_name, h.hospital_unit, t.week_end_date, t.invoice_date, u.first_name, u.last_name, u.staff_id, t.total_worked_hours, t.exp, t.total_amount_of_staff "
//                        . "FROM {{user}} u, {{hospital_registration}} hr, {{hospital_unit}} h, {{timesheet_payment_details_for_staff}} td, {{timesheet}} t  "
//                        . "WHERE u.id = td.staff_id AND t.staff_id = td.staff_id AND td.invoice_date = t.invoice_date AND "
//                        . "td.week_end_date = t.week_end_date AND t.hospital_unit_id = h.hospital_unit_id AND t.paid_to_staff = 'N' AND "
//                        . "h.hospital_id = hr.hospital_id AND td.training_deduction_apply ='Y' AND t.invoice_date = '" . $la_shiftDetailsValue['invoice_date'] . "' "
//                        . "AND t.week_end_date = '" . $la_shiftDetailsValue['week_end_date'] . "' AND t.staff_id = '" . $la_shiftDetailsValue['staff_id'] . "'";

                $sqlQueryForTimesheet = "SELECT t.id, t.staff_id FROM {{timesheet}} t WHERE t.invoice_date = '" . $la_shiftDetailsValue['invoice_date'] . "' "
                        . "AND t.week_end_date = '" . $la_shiftDetailsValue['week_end_date'] . "' AND t.staff_id = '" . $la_shiftDetailsValue['staff_id'] . "'";

                $commandForTimesheet = Yii::app()->db->createCommand($sqlQueryForTimesheet)->queryAll();

                foreach ($commandForTimesheet as $la_timesheetValue) {
                    $data = array(
                        "paid_to_staff" => 'Y'
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_timesheet', $data, 'id=:id', array(':id' => $la_timesheetValue['id'])
                    );

                    $sqlQueryForGetStaffDetails = "SELECT u.email, u.first_name FROM {{staff_registration}} s, {{pay_type}} p, {{user}} u WHERE u.staff_id = s.staff_id AND s.pay_type_id = p.pay_type_id AND p.pay_type = 'LTD' AND u.id = '" . $la_timesheetValue['staff_id'] . "'";
                    $commandForGetStaffDetails = Yii::app()->db->createCommand($sqlQueryForGetStaffDetails)->queryAll();

                    if (count($commandForGetStaffDetails) != 0) {

                        $modelPdf = new StaffDetailsForPdfGenerate;
                        $rnd = rand(0, 9999);
                        $referenceId = date("Y-m-d h:i:s") . " - " . time() . " - " . $la_timesheetValue['staff_id'] . " - " . $rnd;
                        $modelPdf->staff_id = $la_timesheetValue['staff_id'];
                        $modelPdf->invoice_date = $la_shiftDetailsValue['invoice_date'];
                        $modelPdf->reference_id = md5(md5($referenceId));

                        $sqlQueryForDuplicateEntry = "SELECT * FROM {{staff_details_for_pdf_generate}} s WHERE s.staff_id = '" . $la_timesheetValue['staff_id'] . "' "
                                . "AND s.invoice_date = '" . $la_shiftDetailsValue['invoice_date'] . "'";
                        $commandForDuplicateEntry = Yii::app()->db->createCommand($sqlQueryForDuplicateEntry)->queryAll();

                        if (count($commandForDuplicateEntry) == 0) {
                            $modelPdf->save();

                            $to = $commandForGetStaffDetails[0]['email'];
                            $subject = 'Ivers Care : Payment Voucher for ' . Utility::changeDateToUK($la_shiftDetailsValue['invoice_date']) . '!!';
                            $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                            $headers .= "From: <donotreply@iverscareconnect.co.uk>" . "\r\n";
                            $url = Yii::app()->getBaseUrl(true) . "/index.php?r=site/getVoucher&reference=" . md5($referenceId);
                            $message = '<p><h2>Hi! ' . $commandForGetStaffDetails[0]['first_name'] . '</h2></p><p>Please <span>click the below button to </span>download invoice.</p>';
                            $message .= '<table cellspacing="0" cellpadding="0"> <tr>';
                            $message .= '<td align="center" width="300" height="40" bgcolor="#4f27d2" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">';
                            $message .= '<a href="' . $url . '" style="color: #ffffff; font-size:16px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">Click to download invoice!</a>';
                            $message .= '</td> </tr> </table>';

                            mail($to, $subject, $message, $headers);
                        }
                    }
//                    $this->renderPartial('html2pdf', array('model' => $value));
                }
                $data = array(
                    "paid_status" => 'Y'
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_timesheet_payment_details_for_staff', $data, 'id=:id', array(':id' => $la_shiftDetailsValue['id'])
                );
            }
        }

        $ls_staffUpdatePageUrl = YII::app()->createUrl('finance/TimesheetPaymentDetailsForStaff/makePayment');
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actionexportAllInvoice() {
        $model = new TimesheetPaymentDetailsForStaff;

        $this->render('exportInvoice', array(
            'model' => $model,
        ));
    }

    public function actionExportGenerateInvoice() {
        if ($_POST['invoice_date'] != "") {
            $invoiceDate = Utility::changeDateToMysql($_POST['invoice_date']);
        }

        $sqlQuery = "SELECT p.pay_type, t.id, t.staff_id, hr.hospital_name, h.hospital_unit, t.week_end_date, t.invoice_date, u.first_name, u.last_name, t.total_worked_hours, t.exp, t.total_amount_of_staff, td.training_deduction_amount "
                . "FROM {{staff_registration}} s, {{pay_type}} p, {{user}} u, {{hospital_registration}} hr, {{hospital_unit}} h, {{timesheet_payment_details_for_staff}} td, {{timesheet}} t  "
                . "WHERE s.staff_id = u.staff_id AND s.pay_type_id = p.pay_type_id AND u.id = td.staff_id AND t.staff_id = td.staff_id AND td.invoice_date = t.invoice_date AND td.week_end_date = t.week_end_date "
                . "AND t.hospital_unit_id = h.hospital_unit_id AND h.hospital_id = hr.hospital_id AND td.training_deduction_apply ='Y' AND t.invoice_date = '" . $invoiceDate . "' ORDER BY u.first_name";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($command);die;
        $i = 0;
        $outputArray = array();


        $z = 0;
        $outputFinalArray = array();
        $outputFinalArray[$z]['hospital'] = "Hospital Group";
        $outputFinalArray[$z]['hospital_unit'] = "Hospital Name";
        $outputFinalArray[$z]['invoice_date'] = "Invoice Date";
        $outputFinalArray[$z]['description'] = "Staff Full name & Date of Shift & Hospital";
        $outputFinalArray[$z]['pay_type'] = "Pay Type";
        $outputFinalArray[$z]['total_worked_hours'] = "Hours worked";
        $outputFinalArray[$z]['rate_for_that_shift'] = "Rate for that shift";
        $outputFinalArray[$z]['total'] = "Total";
        $z++;

        $j = 0;

        $y = 0;
        $outputExpArray = array();

        foreach ($command as $value) {

            $sqlQueryForGetTimesheetHour = "SELECT * FROM {{timesheet}} t  WHERE t.id = '" . $command[$j]['id'] . "'";
            $commandForGetTimesheetHour = Yii::app()->db->createCommand($sqlQueryForGetTimesheetHour)->queryAll();

            foreach ($commandForGetTimesheetHour as $la_value) {

                if ($la_value['monday'] != 0) {
                    $day = strtotime('last Monday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['monday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['monday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['tuesday'] != 0) {
                    $day = strtotime('last Tuesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['tuesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['tuesday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['wednesday'] != 0) {
                    $day = strtotime('last Wednesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['wednesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['wednesday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['thursday'] != 0) {
                    $day = strtotime('last Thursday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['thursday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['thursday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['friday'] != 0) {
                    $day = strtotime('last Friday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['friday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['friday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['saturday'] != 0) {
//                    $day = strtotime('last Saturday', strtotime($command[$j]['week_end_date']));
//                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", strtotime($command[$j]['week_end_date'])));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['saturday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['saturday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['sunday'] != 0) {
                    $day = strtotime('last Sunday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['sunday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['sunday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }
            }

            if ($commandForGetTimesheetHour[0]['exp'] != 0) {
                $outputExpArray[$y]['staff_id'] = $command[$j]['staff_id'];
                $outputExpArray[$y]['hospital_unit'] = $command[$j]['hospital_unit'];
                $outputExpArray[$y]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                $outputExpArray[$y]['week_end_date'] = Utility::changeDateToUK($command[$j]['week_end_date']);
                $outputExpArray[$y]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . ". Add expenses for Week End Date : " . Utility::changeDateToUKWithSlash($command[$j]['week_end_date']);
                $outputExpArray[$y++]['exp'] = $la_value['exp'];
            }
            $j++;
        }

        $outputArrayForTraining = array();
        $k = 0;

        $sqlQueryForTrainingDeduction = "SELECT td.staff_id, td.week_end_date, td.invoice_date, u.first_name, u.last_name, td.training_deduction_amount "
                . "FROM {{user}} u, {{timesheet_payment_details_for_staff}} td  WHERE u.id = td.staff_id  "
                . "AND td.training_deduction_apply ='Y' AND td.invoice_date = '" . $invoiceDate . "'";
        $commandForTrainingDeduction = Yii::app()->db->createCommand($sqlQueryForTrainingDeduction)->queryAll();

        foreach ($commandForTrainingDeduction as $la_trainingValue) {
            $outputArrayForTraining[$k]['staff_id'] = $la_trainingValue['staff_id'];
            $outputArrayForTraining[$k]['invoice_date'] = Utility::changeDateToUK($la_trainingValue['invoice_date']);
            $outputArrayForTraining[$k]['description'] = $la_trainingValue['first_name'] . " " . $la_trainingValue['last_name'] . " Training deductions " . Utility::changeDateToUKWithSlash($la_trainingValue['week_end_date']);
            $outputArrayForTraining[$k]['total_worked_hours'] = "1";
            $outputArrayForTraining[$k]['rate_for_that_shift'] = "-" . $la_trainingValue['training_deduction_amount'];
            $outputArrayForTraining[$k]['total'] = "";
            $k++;
        }

        $li_totalBalance = 0;
        for ($x = 0; $x < count($outputArray); $x++) {
            $outputFinalArray[$z]['hospital'] = $outputArray[$x]['hospital'];
            $outputFinalArray[$z]['hospital_unit'] = $outputArray[$x]['hospital_unit'];
            $outputFinalArray[$z]['invoice_date'] = $outputArray[$x]['invoice_date'];
            $outputFinalArray[$z]['description'] = $outputArray[$x]['description'];
            $outputFinalArray[$z]['pay_type'] = $outputArray[$x]['pay_type'];
            $outputFinalArray[$z]['total_worked_hours'] = $outputArray[$x]['total_worked_hours'];
            $outputFinalArray[$z]['rate_for_that_shift'] = $outputArray[$x]['rate_for_that_shift'];
            $outputFinalArray[$z]['total'] = $outputArray[$x]['total'];

            $li_totalBalance += $outputArray[$x]['total'];

            if ($outputArray[$x]['staff_id'] != $outputArray[$x + 1]['staff_id']) {
                foreach ($outputExpArray as $la_expValue) {
                    if ($la_expValue['staff_id'] == $outputArray[$x]['staff_id']) {
                        $z++;
                        $outputFinalArray[$z]['hospital'] = "";
                        $outputFinalArray[$z]['hospital_unit'] = $la_expValue['hospital_unit'];
                        $outputFinalArray[$z]['invoice_date'] = $la_expValue['invoice_date'];
                        $outputFinalArray[$z]['description'] = $la_expValue['description'];
                        $outputFinalArray[$z]['pay_type'] = $outputArray[$x]['pay_type'];
                        $outputFinalArray[$z]['total_worked_hours'] = "1";
                        $outputFinalArray[$z]['rate_for_that_shift'] = $la_expValue['exp'];
                        $outputFinalArray[$z]['total'] = $la_expValue['exp'];
                        $outputFinalArray[$z]['balance'] = "";
                        $li_totalBalance += $la_expValue['exp'];
                    }
                }
                foreach ($outputArrayForTraining as $la_trainingValue) {
                    if ($la_trainingValue['staff_id'] == $outputArray[$x]['staff_id']) {
                        $z++;
                        $outputFinalArray[$z]['hospital'] = "";
                        $outputFinalArray[$z]['hospital_unit'] = "";
                        $outputFinalArray[$z]['invoice_date'] = $la_trainingValue['invoice_date'];
                        $outputFinalArray[$z]['description'] = $la_trainingValue['description'];
                        $outputFinalArray[$z]['pay_type'] = $outputArray[$x]['pay_type'];
                        $outputFinalArray[$z]['total_worked_hours'] = $la_trainingValue['total_worked_hours'];
                        $outputFinalArray[$z]['rate_for_that_shift'] = $la_trainingValue['rate_for_that_shift'];
                        $outputFinalArray[$z]['total'] = $la_trainingValue['rate_for_that_shift'];
                        $outputFinalArray[$z]['balance'] = $li_totalBalance + $la_trainingValue['rate_for_that_shift'];
                        $li_totalBalance += $la_trainingValue['rate_for_that_shift'];
                    }
                }
                $li_totalBalance = 0;
            }
            $z++;
        }

        $date = time();
        $lv_outputFile = "Staff Invoice - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputFinalArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('exportInvoice');
    }

    public function actionExportGenerateInvoiceBeforeDeduction() {
        if ($_POST['invoice_date'] != "") {
            $invoiceDate = Utility::changeDateToMysql($_POST['invoice_date']);
        }

        $sqlQuery = "SELECT p.pay_type, t.id, t.staff_id, hr.hospital_name, h.hospital_unit, t.week_end_date, t.invoice_date, u.first_name, u.last_name, t.total_worked_hours, t.exp, t.total_amount_of_staff, td.training_deduction_amount "
                . "FROM {{staff_registration}} s, {{pay_type}} p, {{user}} u, {{hospital_registration}} hr, {{hospital_unit}} h, {{timesheet_payment_details_for_staff}} td, {{timesheet}} t  "
                . "WHERE s.staff_id = u.staff_id AND s.pay_type_id = p.pay_type_id AND u.id = td.staff_id AND t.staff_id = td.staff_id AND td.invoice_date = t.invoice_date AND td.week_end_date = t.week_end_date "
                . "AND t.hospital_unit_id = h.hospital_unit_id AND h.hospital_id = hr.hospital_id AND td.training_deduction_apply ='N' AND t.invoice_date = '" . $invoiceDate . "' ORDER BY u.first_name";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($command);die;
        $i = 0;
        $outputArray = array();


        $z = 0;
        $outputFinalArray = array();
        $outputFinalArray[$z]['hospital'] = "Hospital Group";
        $outputFinalArray[$z]['hospital_unit'] = "Hospital Name";
        $outputFinalArray[$z]['invoice_date'] = "Invoice Date";
        $outputFinalArray[$z]['description'] = "Staff Full name & Date of Shift & Hospital";
        $outputFinalArray[$z]['pay_type'] = "Pay Type";
        $outputFinalArray[$z]['total_worked_hours'] = "Hours worked";
        $outputFinalArray[$z]['rate_for_that_shift'] = "Rate for that shift";
        $outputFinalArray[$z]['total'] = "Total";
        $z++;

        $j = 0;

        $y = 0;
        $outputExpArray = array();

        foreach ($command as $value) {

            $sqlQueryForGetTimesheetHour = "SELECT * FROM {{timesheet}} t  WHERE t.id = '" . $command[$j]['id'] . "'";
            $commandForGetTimesheetHour = Yii::app()->db->createCommand($sqlQueryForGetTimesheetHour)->queryAll();

            foreach ($commandForGetTimesheetHour as $la_value) {

                if ($la_value['monday'] != 0) {
                    $day = strtotime('last Monday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['monday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['monday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['tuesday'] != 0) {
                    $day = strtotime('last Tuesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['tuesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['tuesday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['wednesday'] != 0) {
                    $day = strtotime('last Wednesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['wednesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['wednesday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['thursday'] != 0) {
                    $day = strtotime('last Thursday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['thursday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['thursday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['friday'] != 0) {
                    $day = strtotime('last Friday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['friday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['friday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['saturday'] != 0) {
                    $day = strtotime('last Saturday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['saturday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['saturday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['sunday'] != 0) {
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", strtotime($command[$j]['week_end_date'])));

                    $outputArray[$i]['staff_id'] = $command[$j]['staff_id'];
                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['pay_type'] = $command[$j]['pay_type'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['sunday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total'] = $la_value['sunday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }
            }

            if ($commandForGetTimesheetHour[0]['exp'] != 0) {
                $outputExpArray[$y]['staff_id'] = $command[$j]['staff_id'];
                $outputExpArray[$y]['hospital_unit'] = $command[$j]['hospital_unit'];
                $outputExpArray[$y]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                $outputExpArray[$y]['week_end_date'] = Utility::changeDateToUK($command[$j]['week_end_date']);
                $outputExpArray[$y]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . ". Add expenses for Week End Date : " . Utility::changeDateToUKWithSlash($command[$j]['week_end_date']);
                $outputExpArray[$y++]['exp'] = $la_value['exp'];
            }
            $j++;
        }

        $outputArrayForTraining = array();
        $k = 0;

        $sqlQueryForTrainingDeduction = "SELECT td.staff_id, td.week_end_date, td.invoice_date, u.first_name, u.last_name, td.training_deduction_amount "
                . "FROM {{user}} u, {{timesheet_payment_details_for_staff}} td  WHERE u.id = td.staff_id  "
                . "AND td.training_deduction_apply ='N' AND td.invoice_date = '" . $invoiceDate . "'";
        $commandForTrainingDeduction = Yii::app()->db->createCommand($sqlQueryForTrainingDeduction)->queryAll();

        foreach ($commandForTrainingDeduction as $la_trainingValue) {
            $outputArrayForTraining[$k]['staff_id'] = $la_trainingValue['staff_id'];
            $outputArrayForTraining[$k]['invoice_date'] = Utility::changeDateToUK($la_trainingValue['invoice_date']);
            $outputArrayForTraining[$k]['description'] = $la_trainingValue['first_name'] . " " . $la_trainingValue['last_name'] . " Training deductions " . Utility::changeDateToUKWithSlash($la_trainingValue['week_end_date']);
            $outputArrayForTraining[$k]['total_worked_hours'] = "1";
            $outputArrayForTraining[$k]['rate_for_that_shift'] = "-" . $la_trainingValue['training_deduction_amount'];
            $outputArrayForTraining[$k]['total'] = "";
            $k++;
        }

        $li_totalBalance = 0;
        for ($x = 0; $x < count($outputArray); $x++) {
            $outputFinalArray[$z]['hospital'] = $outputArray[$x]['hospital'];
            $outputFinalArray[$z]['hospital_unit'] = $outputArray[$x]['hospital_unit'];
            $outputFinalArray[$z]['invoice_date'] = $outputArray[$x]['invoice_date'];
            $outputFinalArray[$z]['description'] = $outputArray[$x]['description'];
            $outputFinalArray[$z]['pay_type'] = $outputArray[$x]['pay_type'];
            $outputFinalArray[$z]['total_worked_hours'] = $outputArray[$x]['total_worked_hours'];
            $outputFinalArray[$z]['rate_for_that_shift'] = $outputArray[$x]['rate_for_that_shift'];
            $outputFinalArray[$z]['total'] = $outputArray[$x]['total'];

            $li_totalBalance += $outputArray[$x]['total'];

            if ($outputArray[$x]['staff_id'] != $outputArray[$x + 1]['staff_id']) {
                foreach ($outputExpArray as $la_expValue) {
                    if ($la_expValue['staff_id'] == $outputArray[$x]['staff_id']) {
                        $z++;
                        $outputFinalArray[$z]['hospital'] = "";
                        $outputFinalArray[$z]['hospital_unit'] = $la_expValue['hospital_unit'];
                        $outputFinalArray[$z]['invoice_date'] = $la_expValue['invoice_date'];
                        $outputFinalArray[$z]['description'] = $la_expValue['description'];
                        $outputFinalArray[$z]['pay_type'] = $outputArray[$x]['pay_type'];
                        $outputFinalArray[$z]['total_worked_hours'] = "1";
                        $outputFinalArray[$z]['rate_for_that_shift'] = $la_expValue['exp'];
                        $outputFinalArray[$z]['total'] = $la_expValue['exp'];
                        $outputFinalArray[$z]['balance'] = "";
                        $li_totalBalance += $la_expValue['exp'];
                    }
                }
                foreach ($outputArrayForTraining as $la_trainingValue) {
                    if ($la_trainingValue['staff_id'] == $outputArray[$x]['staff_id']) {
                        $z++;
                        $outputFinalArray[$z]['hospital'] = "";
                        $outputFinalArray[$z]['hospital_unit'] = "";
                        $outputFinalArray[$z]['invoice_date'] = $la_trainingValue['invoice_date'];
                        $outputFinalArray[$z]['description'] = $la_trainingValue['description'];
                        $outputFinalArray[$z]['pay_type'] = $outputArray[$x]['pay_type'];
                        $outputFinalArray[$z]['total_worked_hours'] = $la_trainingValue['total_worked_hours'];
                        $outputFinalArray[$z]['rate_for_that_shift'] = $la_trainingValue['rate_for_that_shift'];
                        $outputFinalArray[$z]['total'] = $la_trainingValue['rate_for_that_shift'];
                        $outputFinalArray[$z]['balance'] = $li_totalBalance + $la_trainingValue['rate_for_that_shift'];
                        $li_totalBalance += $la_trainingValue['rate_for_that_shift'];
                    }
                }
                $li_totalBalance = 0;
            }
            $z++;
        }

        $date = time();
        $lv_outputFile = "Staff Invoice - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputFinalArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('exportInvoice');
    }

    public function actionExportGenerateInvoiceForHospital() {
        if ($_POST['invoice_date'] != "") {
            $invoiceDate = Utility::changeDateToMysql($_POST['invoice_date']);
        }

        $sqlQuery = "SELECT t.id, t.staff_id, hr.hospital_name, h.hospital_unit, t.week_end_date, t.invoice_date, u.first_name, u.last_name, t.total_worked_hours, t.exp, t.total_amount_of_hospital, td.training_deduction_amount "
                . "FROM {{user}} u, {{hospital_registration}} hr, {{hospital_unit}} h, {{timesheet_payment_details_for_staff}} td, {{timesheet}} t  "
                . "WHERE u.id = td.staff_id AND t.staff_id = td.staff_id AND td.invoice_date = t.invoice_date AND td.week_end_date = t.week_end_date "
                . "AND t.hospital_unit_id = h.hospital_unit_id AND h.hospital_id = hr.hospital_id AND td.training_deduction_apply ='Y' AND t.invoice_date = '" . $invoiceDate . "' ORDER BY hr.hospital_name";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//        print_r($command);die;
        $i = 0;

        $outputArray = array();
        $outputArray[$i]['hospital'] = "Hospital Group";
        $outputArray[$i]['hospital_unit'] = "Hospital Name";
        $outputArray[$i]['invoice_date'] = "Invoice Date";
        $outputArray[$i]['description'] = "Staff Full name & Date of Shift & Hospital";
        $outputArray[$i]['total_worked_hours'] = "Hours worked";
        $outputArray[$i]['rate_for_that_shift'] = "Rate for that shift";
        $i++;

        $j = 0;

        foreach ($command as $value) {

            $sqlQueryForGetTimesheetHour = "SELECT * FROM {{timesheet}} t  WHERE t.id = '" . $command[$j]['id'] . "'";
            $commandForGetTimesheetHour = Yii::app()->db->createCommand($sqlQueryForGetTimesheetHour)->queryAll();

            foreach ($commandForGetTimesheetHour as $la_value) {

                if ($la_value['monday'] != 0) {
                    $day = strtotime('last Monday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['monday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_hospital'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['tuesday'] != 0) {
                    $day = strtotime('last Tuesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['tuesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_hospital'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['wednesday'] != 0) {
                    $day = strtotime('last Wednesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['wednesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_hospital'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['thursday'] != 0) {
                    $day = strtotime('last Thursday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['thursday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_hospital'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['friday'] != 0) {
                    $day = strtotime('last Friday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['friday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_hospital'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['saturday'] != 0) {
                    $day = strtotime('last Saturday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['saturday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_hospital'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }

                if ($la_value['sunday'] != 0) {
                    $day = strtotime('last Sunday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate . " " . $command[$j]['hospital_unit'];
                    $outputArray[$i]['total_worked_hours'] = $la_value['sunday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_hospital'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];

                    $i++;
                }
            }
            $j++;
        }

        $date = time();
        $lv_outputFile = "Hospital Invoice - " . $date;
        $lv_delimiter = ",";

        Utility::convertToCsv($outputArray, $lv_outputFile, $lv_delimiter);
        exit();
        $this->render('exportInvoice');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TimesheetPaymentDetailsForStaff('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TimesheetPaymentDetailsForStaff']))
            $model->attributes = $_GET['TimesheetPaymentDetailsForStaff'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TimesheetPaymentDetailsForStaff the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = TimesheetPaymentDetailsForStaff::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TimesheetPaymentDetailsForStaff $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'timesheet-payment-details-for-staff-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetTrainingDeduction() {
        $sqlQuery = "SELECT * FROM {{training_details}} t WHERE t.staff_id ='" . $_POST['staff_id'] . "' AND t.remaining_amount > 0";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $li_amount = 00.00;
        $li_result = 00.00;
        foreach ($command as $value) {
            if ($value['remaining_amount'] > $value['deduction_amount']) {
                $li_amount = $value['deduction_amount'];
            } else {
                $li_amount = $value['remaining_amount'];
            }
            $li_result = $li_result + $li_amount;
        }
        echo $li_result;
    }

}
