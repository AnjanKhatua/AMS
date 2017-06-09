<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $defaultAction = 'login';

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                if ($_SESSION['logged_user']['type'] === 'A' || $_SESSION['logged_user']['type'] === 'D' || $_SESSION['logged_user']['type'] === 'M' || $_SESSION['logged_user']['type'] === 'C') {
                    $this->redirect(Yii::app()->createUrl('admin/default/index'));
                } elseif ($_SESSION['logged_user']['type'] === 'S') {
                    $this->redirect(Yii::app()->createUrl('staff/default/index'));
                } elseif ($_SESSION['logged_user']['type'] === 'F') {
                    $this->redirect(Yii::app()->createUrl('finance/default/index'));
                }
            }
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionChangePasswordforAll() {
        $ls_passwordSql = "SELECT * FROM {{staff_registration}} s WHERE s.staff_id != 'D'";
        $commandPassword = Yii::app()->db->createCommand($ls_passwordSql)->queryAll();

        foreach ($commandPassword as $lo_value) {
            if ($lo_value['date_of_birth'] != "") {
                $ld_dateOfBirth = Utility::changeDateToUK($lo_value['date_of_birth']);
                $ld_dateOfBirth = date('dmY', strtotime($ld_dateOfBirth));
                $ls_password = md5($ld_dateOfBirth);
                $data = array(
                    "date_of_birth" => $lo_value['date_of_birth'],
                    "password" => $ls_password
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_user', $data, 'staff_id=:staff_id', array(':staff_id' => $lo_value['staff_id'])
                );
            }
        }
    }

    /*
     * Date calculation for mail of all expiry
     */

    public function actionSendTwoMonthExpiryNotification() {
        $ls_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 60 day"));
        $ls_expirySql = "SELECT * FROM {{staff_registration}} s, {{job_type}} j, {{staff_job_type_map}} jm WHERE j.job_type = 'Nurse' AND j.job_type_id = jm.job_type_id AND s.staff_id = jm.staff_id AND `re_validation_renewal_date` =  '" . $ls_dateThreshold . "'";
        $commandExpiry = Yii::app()->db->createCommand($ls_expirySql)->queryAll();

        $ls_email = '';
        foreach ($commandExpiry AS $lv_expiry) {
            $data = array();

            $ls_email .= $lv_expiry['email'] . ', ';
            $data['first_name'] = $lv_expiry['first_name'];
            $data['email'] = $lv_expiry['email'];

            $data['time'] = "60 days";

            $ls_expiry = '';
            $ls_notExpired = '';

            if ($lv_expiry['re_validation_renewal_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Re-validation renewal date : ' . Utility::changeDateToUK($lv_expiry['re_validation_renewal_date']) . "<br>";
            }

            $data['expiry'] = $ls_expiry;

            Utility::expiryRenewalMail($data);
        }
        echo 'Re-validation renewal expiry mails have been sent to ' . $ls_email;
    }

    public function actionSendYearlyExpiryNotification() {
        $ls_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 365 day"));
        $ls_expirySql = "SELECT * FROM {{staff_registration}} s, {{job_type}} j, {{staff_job_type_map}} jm WHERE j.job_type = 'Nurse' AND j.job_type_id = jm.job_type_id AND s.staff_id = jm.staff_id AND `medication_assessment_completed_date` =  '" . $ls_dateThreshold . "'";
        $commandExpiry = Yii::app()->db->createCommand($ls_expirySql)->queryAll();

        $ls_email = '';
        foreach ($commandExpiry AS $lv_expiry) {
            $data = array();

            $ls_email .= $lv_expiry['email'] . ', ';
            $data['first_name'] = $lv_expiry['first_name'];
            $data['email'] = $lv_expiry['email'];

            $data['time'] = "1 year";

            $ls_expiry = '';
            $ls_notExpired = '';

            if ($lv_expiry['medication_assessment_completed_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Medication assessment completed date : ' . Utility::changeDateToUK($lv_expiry['medication_assessment_completed_date']) . "<br>";
            }

            $data['expiry'] = $ls_expiry;

            Utility::expiryRenewalMail($data);
        }
        echo 'Re-validation renewal expiry mails have been sent to ' . $ls_email;
    }

    public function actionSendMonthlyExpiryNotification() {
        $ls_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 30 day"));
        $ls_expirySql = "SELECT * FROM {{staff_registration}} WHERE `visa_expiry_date` =  '" . $ls_dateThreshold . "' OR `dbs_expiry` = '" . $ls_dateThreshold . "' OR `mandatory_training_expiry_date` = '" . $ls_dateThreshold . "' OR `pin_expiry_date` = '" . $ls_dateThreshold . "'";
        $commandExpiry = Yii::app()->db->createCommand($ls_expirySql)->queryAll();

        $ls_email = '';
        foreach ($commandExpiry AS $lv_expiry) {
            $data = array();

            $ls_email .= $lv_expiry['email'] . ', ';
            $data['first_name'] = $lv_expiry['first_name'];
            $data['email'] = $lv_expiry['email'];

            $data['time'] = "30 days";

            $ls_expiry = '';
            $ls_notExpired = '';

            if ($lv_expiry['visa_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Visa Expiry Date : ' . Utility::changeDateToUK($lv_expiry['visa_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Visa Expiry Date : ' . Utility::changeDateToUK($lv_expiry['visa_expiry_date']) . "<br>";
            }

            if ($lv_expiry['dbs_expiry'] == $ls_dateThreshold) {
                $ls_expiry.= 'DBS Expiry Date : ' . Utility::changeDateToUK($lv_expiry['dbs_expiry']) . "<br>";
            } else {
                $ls_notExpired.= 'DBS Expiry Date : ' . Utility::changeDateToUK($lv_expiry['dbs_expiry']) . "<br>";
            }

            if ($lv_expiry['mandatory_training_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Mandatory Training Expiry Date : ' . Utility::changeDateToUK($lv_expiry['mandatory_training_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Mandatory Training Expiry Date : ' . Utility::changeDateToUK($lv_expiry['mandatory_training_expiry_date']) . "<br>";
            }

            if ($lv_expiry['pin_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Pin Expiry Date : ' . Utility::changeDateToUK($lv_expiry['pin_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Pin Expiry Date : ' . Utility::changeDateToUK($lv_expiry['pin_expiry_date']) . "<br>";
            }
            $data['expiry'] = $ls_expiry;
            $data['notExpiry'] = $ls_notExpired;

            Utility::expiryMail($data);
        }
        echo 'Monthly Expiry mails have been sent to ' . $ls_email;
    }

    public function actionSendWeeklyExpiryNotification() {
        $ls_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 7 day"));
        $ls_expirySql = "SELECT * FROM {{staff_registration}} WHERE `visa_expiry_date` =  '" . $ls_dateThreshold . "' OR `dbs_expiry` = '" . $ls_dateThreshold . "' OR `mandatory_training_expiry_date` = '" . $ls_dateThreshold . "' OR `pin_expiry_date` = '" . $ls_dateThreshold . "'";
        $commandExpiry = Yii::app()->db->createCommand($ls_expirySql)->queryAll();

        $ls_email = '';
        foreach ($commandExpiry AS $lv_expiry) {
            $data = array();

            $ls_email .= $lv_expiry['email'] . ', ';
            $data['first_name'] = $lv_expiry['first_name'];
            $data['email'] = $lv_expiry['email'];

            $data['time'] = "7 days";

            $ls_expiry = '';
            $ls_notExpired = '';

            if ($lv_expiry['visa_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Visa Expiry Date : ' . Utility::changeDateToUK($lv_expiry['visa_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Visa Expiry Date : ' . Utility::changeDateToUK($lv_expiry['visa_expiry_date']) . "<br>";
            }

            if ($lv_expiry['dbs_expiry'] == $ls_dateThreshold) {
                $ls_expiry.= 'DBS Expiry Date : ' . Utility::changeDateToUK($lv_expiry['dbs_expiry']) . "<br>";
            } else {
                $ls_notExpired.= 'DBS Expiry Date : ' . Utility::changeDateToUK($lv_expiry['dbs_expiry']) . "<br>";
            }

            if ($lv_expiry['mandatory_training_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Mandatory Training Expiry Date : ' . Utility::changeDateToUK($lv_expiry['mandatory_training_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Mandatory Training Expiry Date : ' . Utility::changeDateToUK($lv_expiry['mandatory_training_expiry_date']) . "<br>";
            }

            if ($lv_expiry['pin_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Pin Expiry Date : ' . Utility::changeDateToUK($lv_expiry['pin_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Pin Expiry Date : ' . Utility::changeDateToUK($lv_expiry['pin_expiry_date']) . "<br>";
            }
            $data['expiry'] = $ls_expiry;
            $data['notExpiry'] = $ls_notExpired;

            Utility::expiryMail($data);
        }
        echo 'Weekly Expiry mails have been sent to ' . $ls_email;
    }

    public function actionSendDailyExpiryNotification() {
        $ls_dateThreshold = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 1 day"));
        $ls_expirySql = "SELECT * FROM {{staff_registration}} WHERE `visa_expiry_date` =  '" . $ls_dateThreshold . "' OR `dbs_expiry` = '" . $ls_dateThreshold . "' OR `mandatory_training_expiry_date` = '" . $ls_dateThreshold . "' OR `pin_expiry_date` = '" . $ls_dateThreshold . "'";
        $commandExpiry = Yii::app()->db->createCommand($ls_expirySql)->queryAll();


        $ls_email = '';
        foreach ($commandExpiry AS $lv_expiry) {

            $ls_email .= $lv_expiry['email'] . ', ';
            $data = array();

            $data['first_name'] = $lv_expiry['first_name'];
            $data['email'] = $lv_expiry['email'];

            $data['time'] = "1 day";

            $ls_expiry = '';
            $ls_notExpired = '';

            if ($lv_expiry['visa_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Visa Expiry Date : ' . Utility::changeDateToUK($lv_expiry['visa_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Visa Expiry Date : ' . Utility::changeDateToUK($lv_expiry['visa_expiry_date']) . "<br>";
            }

            if ($lv_expiry['dbs_expiry'] == $ls_dateThreshold) {
                $ls_expiry.= 'DBS Expiry Date : ' . Utility::changeDateToUK($lv_expiry['dbs_expiry']) . "<br>";
            } else {
                $ls_notExpired.= 'DBS Expiry Date : ' . Utility::changeDateToUK($lv_expiry['dbs_expiry']) . "<br>";
            }

            if ($lv_expiry['mandatory_training_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Mandatory Training Expiry Date : ' . Utility::changeDateToUK($lv_expiry['mandatory_training_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Mandatory Training Expiry Date : ' . Utility::changeDateToUK($lv_expiry['mandatory_training_expiry_date']) . "<br>";
            }

            if ($lv_expiry['pin_expiry_date'] == $ls_dateThreshold) {
                $ls_expiry.= 'Pin Expiry Date : ' . Utility::changeDateToUK($lv_expiry['pin_expiry_date']) . "<br>";
            } else {
                $ls_notExpired.= 'Pin Expiry Date : ' . Utility::changeDateToUK($lv_expiry['pin_expiry_date']) . "<br>";
            }
            $data['expiry'] = $ls_expiry;
            $data['notExpiry'] = $ls_notExpired;


            Utility::expiryMail($data);
        }

        echo 'Daily Expiry mails have been sent to ' . $ls_email;
    }

    /*
     * End of function
     */

    public function actionForgotPassword() {
        $model = new ForgotPassword;
        $model->attributes = $_POST['ForgotPassword'];

        $ls_msg = Utility::validateEmailField($_POST['ForgotPassword']['email']);
        if (isset($_POST['ForgotPassword']['email']) && $ls_msg != "") {
            $model->addError('email', $ls_msg);
        }

        if (isset($_POST['ForgotPassword']['email']) && $_POST['ForgotPassword']['email'] != "") {
            $rnd = time();
            $ls_activationKey = $rnd . "-" . "ICS" . "-" . $rnd . "-" . "2016";
            $ls_md5ActivationKey = md5($ls_activationKey);

            $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `email` = '" . $_POST['ForgotPassword']['email'] . "'")->queryAll();

            if (count($command) != 0) {

                $data = array(
                    "activation_key" => $ls_md5ActivationKey
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_user', $data, 'email=:email', array(':email' => $command[0]['email'])
                );

                $to = $_POST['ForgotPassword']['email'];
                $subject = 'Ivers Care : Verification mail for forgot password!!';
                $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: <donotreply@ams.com>" . "\r\n";
                $url = Yii::app()->getBaseUrl(true) . "/index.php?r=site/GetPassword&aKey=" . $ls_md5ActivationKey;
                $message = '<p><h2>Hi! ' . $command[0]['first_name'] . '</h2></p><p>Please <span>click the below button to </span>reset password.</p>';
                $message.='<table cellspacing="0" cellpadding="0"> <tr>';
                $message .= '<td align="center" width="300" height="40" bgcolor="#4f27d2" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">';
                $message .= '<a href="' . $url . '" style="color: #ffffff; font-size:16px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">Click to Reset Password</a>';
                $message .= '</td> </tr> </table>';

                mail($to, $subject, $message, $headers);
                $_SESSION['forgotPassword'] = "Your reset password link has been successfully sent in your email!";
                $model->email = '';
            } else {
                $_SESSION['forgotPassword'] = "";
                $model->addError('email', "Email not found!");
            }
        }
        $this->render('forgotPassword', array('model' => $model));
    }

    public function actionGetPassword() {
        $model = new GetPassword;
        $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `activation_key` = '" . $_GET['aKey'] . "'")->queryAll();

        if (count($command) != 0) {
            $_SESSION['changePasswordInfo'] = $command[0];
        } else {
            $_SESSION['expiredLink'] = "This link has been expired!";
            $this->redirect(Yii::app()->homeUrl);
        }
        if (isset($_POST['GetPassword']))
            if (isset($_SESSION['changePasswordInfo']) && (count($_SESSION['changePasswordInfo']) != 0)) {
                $model->attributes = $_POST['GetPassword'];
                if (isset($_POST['GetPassword']) && ($_POST['GetPassword']['new_password'] != $_POST['GetPassword']['repeat_password'])) {
                    $model->addError('repeat_password', "New password and repeat password do not match!");
                } else {
                    $ls_md5ActivationKey = '';
                    $ls_newPassword = md5($_POST['GetPassword']['new_password']);
                    $data = array(
                        "password" => $ls_newPassword,
                        "activation_key" => $ls_md5ActivationKey
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_user', $data, 'email=:email', array(':email' => $_SESSION['changePasswordInfo']['email'])
                    );
                    $_SESSION['changePassword'] = "Your password link has been successfully update!";
                    unset($_SESSION['changePasswordInfo']);
                }
            }
        $this->render('getPassword', array('model' => $model));
    }

    public function actiongetVoucher() {
        $referenceId = md5($_GET['reference']);
//        $referenceId = '7e8abd8875c96afd1963c12ee4c561e8';
        $sqlQueryForPDF = "SELECT s.invoice_date, s.staff_id, u.first_name, u.last_name, u.address, st.company_name FROM {{staff_details_for_pdf_generate}} s, {{user}} u, {{staff_registration}} st WHERE u.id = s.staff_id AND u.staff_id = st.staff_id AND s.reference_id = '" . $referenceId . "'";
        $commandForPDF = Yii::app()->db->createCommand($sqlQueryForPDF)->queryAll();

        $staffDetailsArray = array();
        $staffDetailsArray['name'] = $commandForPDF[0]['first_name'] . " " . $commandForPDF[0]['last_name'];
        $staffDetailsArray['address'] = $commandForPDF[0]['address'];
        $staffDetailsArray['company_name'] = $commandForPDF[0]['company_name'];

        $sqlQuery = "SELECT t.id, hr.hospital_name, h.hospital_unit, t.week_end_date, t.invoice_date, u.first_name, u.last_name, t.total_worked_hours, t.exp, t.total_amount_of_staff "
                . "FROM {{user}} u, {{hospital_registration}} hr, {{hospital_unit}} h, {{timesheet_payment_details_for_staff}} td, {{timesheet}} t  "
                . "WHERE u.id = td.staff_id AND t.staff_id = td.staff_id AND td.invoice_date = t.invoice_date AND td.week_end_date = t.week_end_date "
                . "AND t.hospital_unit_id = h.hospital_unit_id AND h.hospital_id = hr.hospital_id AND td.training_deduction_apply ='Y' "
                . "AND t.invoice_date = '" . $commandForPDF[0]['invoice_date'] . "' AND t.staff_id = '" . $commandForPDF[0]['staff_id'] . "' ORDER BY t.week_end_date";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $i = 0;

        $outputArray = array();
        $outputArray[$i]['hospital'] = "Hospital Group";
        $outputArray[$i]['hospital_unit'] = "Hospital";
        $outputArray[$i]['invoice_date'] = "Invoice Date";
        $outputArray[$i]['description'] = "Description";
        $outputArray[$i]['total_worked_hours'] = "Hours Worked";
        $outputArray[$i]['rate_for_that_shift'] = "Rate for that shift";
        $outputArray[$i]['total_amount'] = "Amount for each shift";
        $i++;

        $j = 0;

        $p = 0;
        $outputArrayForExp = array();
        $outputArrayForExp[$p]['description'] = "Description";
        $outputArrayForExp[$p++]['expenses'] = "Amount for each week";

        $q = 0;
        $outputArrayForTrainingDeduction = array();
        $outputArrayForTrainingDeduction[$q]['week_end_date'] = "Week end date";
        $outputArrayForTrainingDeduction[$q]['description'] = "Description";
        $outputArrayForTrainingDeduction[$q++]['training_deduction_amount'] = "Amount for each week";

        $sqlQueryForGetTrainingDeduction = "SELECT * FROM {{timesheet_payment_details_for_staff}} t  "
                . "WHERE t.invoice_date = '" . $commandForPDF[0]['invoice_date'] . "' AND t.staff_id = '" . $commandForPDF[0]['staff_id'] . "'";
        $commandForGetTrainingDeduction = Yii::app()->db->createCommand($sqlQueryForGetTrainingDeduction)->queryAll();

        foreach ($commandForGetTrainingDeduction as $la_trainingValue) {
            if ($la_trainingValue['training_deduction_amount'] != 0) {
                $ls_trainingDetails = "";
                $sqlQueryForTrainingDetails = "SELECT a.course_name FROM {{training_details}} t, {{all_training}} a WHERE t.training_id = a.id AND t.staff_id ='" . $commandForPDF[0]['staff_id'] . "' AND t.fees_paid_date LIKE '%" . Utility::changeDateToUK($la_trainingValue['week_end_date']) . "%' ORDER BY t.id";
                $commandForTrainingDetails = Yii::app()->db->createCommand($sqlQueryForTrainingDetails)->queryAll();
                foreach ($commandForTrainingDetails as $la_trainingDetails) {
                    if ($ls_trainingDetails == "") {
                        $ls_trainingDetails = $la_trainingDetails['course_name'];
                    } else {
                        $ls_trainingDetails .= ", " . $la_trainingDetails['course_name'];
                    }
                }
                $outputArrayForTrainingDeduction[$q]['week_end_date'] = $la_trainingValue['week_end_date'];
                $outputArrayForTrainingDeduction[$q]['description'] = $ls_trainingDetails;
                $outputArrayForTrainingDeduction[$q++]['training_deduction_amount'] = $la_trainingValue['training_deduction_amount'];
            }
        }

        foreach ($command as $value) {
            $sqlQueryForGetTimesheetHour = "SELECT * FROM {{timesheet}} t  WHERE t.id = '" . $command[$j]['id'] . "'";
            $commandForGetTimesheetHour = Yii::app()->db->createCommand($sqlQueryForGetTimesheetHour)->queryAll();

            foreach ($commandForGetTimesheetHour as $la_value) {
                if ($la_value['exp'] != 0) {
                    $outputArrayForExp[$p]['description'] = "Week end date : " . Utility::changeDateToUK($command[$j]['week_end_date']) . " and Hospital : " . $command[$j]['hospital_unit'];
                    $outputArrayForExp[$p++]['expenses'] = $la_value['exp'];
                }

                if ($la_value['monday'] != 0) {
                    $day = strtotime('last Monday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate;
                    $outputArray[$i]['total_worked_hours'] = $la_value['monday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total_amount'] = ($la_value['monday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours']);

                    $i++;
                }

                if ($la_value['tuesday'] != 0) {
                    $day = strtotime('last Tuesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate;
                    $outputArray[$i]['total_worked_hours'] = $la_value['tuesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total_amount'] = ($la_value['tuesday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours']);

                    $i++;
                }

                if ($la_value['wednesday'] != 0) {
                    $day = strtotime('last Wednesday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate;
                    $outputArray[$i]['total_worked_hours'] = $la_value['wednesday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total_amount'] = ($la_value['wednesday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours']);


                    $i++;
                }

                if ($la_value['thursday'] != 0) {
                    $day = strtotime('last Thursday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate;
                    $outputArray[$i]['total_worked_hours'] = $la_value['thursday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total_amount'] = ($la_value['thursday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours']);

                    $i++;
                }

                if ($la_value['friday'] != 0) {
                    $day = strtotime('last Friday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate;
                    $outputArray[$i]['total_worked_hours'] = $la_value['friday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total_amount'] = ($la_value['friday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours']);

                    $i++;
                }

                if ($la_value['saturday'] != 0) {
                    $day = strtotime('last Saturday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate;
                    $outputArray[$i]['total_worked_hours'] = $la_value['saturday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total_amount'] = ($la_value['saturday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours']);

                    $i++;
                }

                if ($la_value['sunday'] != 0) {
                    $day = strtotime('last Sunday', strtotime($command[$j]['week_end_date']));
                    $ld_shiftDate = Utility::changeDateToUKWithSlash(date("Y-m-d", $day));

                    $outputArray[$i]['hospital'] = $command[$j]['hospital_name'];
                    $outputArray[$i]['hospital_unit'] = $command[$j]['hospital_unit'];
                    $outputArray[$i]['invoice_date'] = Utility::changeDateToUK($command[$j]['invoice_date']);
                    $outputArray[$i]['description'] = $command[$j]['first_name'] . " " . $command[$j]['last_name'] . " " . $ld_shiftDate;
                    $outputArray[$i]['total_worked_hours'] = $la_value['sunday'];
                    $outputArray[$i]['rate_for_that_shift'] = ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours'];
                    $outputArray[$i]['total_amount'] = ($la_value['sunday'] * ($command[$j]['total_amount_of_staff'] - $command[$j]['exp']) / $command[$j]['total_worked_hours']);

                    $i++;
                }
            }
            $j++;
        }

//        print_r($outputArrayForTrainingDeduction);
//        print_r($outputArrayForExp);
//        print_r($outputArray);
//        die;

        $this->renderPartial('html2pdf', array(
            'allResult' => $outputArray,
            'allExp' => $outputArrayForExp,
            'allTraining' => $outputArrayForTrainingDeduction,
            'allStaffDetails' => $staffDetailsArray,
        ));
    }

}
