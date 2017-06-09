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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view'),
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
            if ($_POST['Timesheet']['staff_id'] != "") {
                for ($i = 0; $i < count($post['Timesheet']['finance_job_type_id']); $i++) {
                    $model = new Timesheet;
                    if (isset($command['id']))
                        $model->staff_id = $command['id'];
                    $model->hospital_unit_id = $post['Timesheet']['hospital_unit_id'][$i];
                    $model->invoice_date = Utility::changeDateToMysql($post['Timesheet']['invoice_date'][$i]);
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
                    $model->total_amount_of_hospital = $model->total_worked_hours * $commandForHospitalRate[0]['rate'];

                    $model->save();
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
            $i = 0;
            if ($_POST['Timesheet']['staff_id'] != "") {
                $model = new Timesheet;
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
                $model->total_amount_of_hospital = $model->total_worked_hours * $commandForHospitalRate[0]['rate'];
                
                if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
