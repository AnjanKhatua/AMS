<?php

class TimesheetPaymentDetailsForHospitalController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'GetTotalAmount'),
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
        $model = new TimesheetPaymentDetailsForHospital;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TimesheetPaymentDetailsForHospital'])) {
            $model->attributes = $_POST['TimesheetPaymentDetailsForHospital'];
            if ($model->total_amount == $model->payment_amount) {
                $ls_getTimesheetId = "SELECT t.id FROM {{timesheet}} t WHERE t.week_end_date = '" . $model->week_end_date . "' AND t.hospital_unit_id = '" . $model->hospital_unit_id . "'";
                $commandFor_getTimesheetId = Yii::app()->db->createCommand($ls_getTimesheetId)->queryAll();

                if (count($commandFor_getTimesheetId) != 0) {
                    foreach ($commandFor_getTimesheetId as $value) {
                        $data = array(
                            "paid_by_hospital" => 'Y'
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_timesheet', $data, 'id=:id', array(':id' => $value['id'])
                        );
                    }
                }
            }
            $model->remaining_amount = $model->total_amount - $model->payment_amount;
            if ($model->total_amount != $model->payment_amount) {
                $model->addError('payment_amount', 'Please enter exact "Payment amount!."');
            } elseif ($model->save())
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

        if (isset($_POST['TimesheetPaymentDetailsForHospital'])) {
            $model->attributes = $_POST['TimesheetPaymentDetailsForHospital'];
            if ($model->total_amount == $model->payment_amount) {
                $ls_getTimesheetId = "SELECT t.id FROM {{timesheet}} t WHERE t.week_end_date = '" . $model->week_end_date . "' AND t.hospital_unit_id = '" . $model->hospital_unit_id . "'";
                $commandFor_getTimesheetId = Yii::app()->db->createCommand($ls_getTimesheetId)->queryAll();

                if (count($commandFor_getTimesheetId) != 0) {
                    foreach ($commandFor_getTimesheetId as $value) {
                        $data = array(
                            "paid_by_hospital" => 'Y'
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_timesheet', $data, 'id=:id', array(':id' => $value['id'])
                        );
                    }
                }
            }
            $model->remaining_amount = $model->total_amount - $model->payment_amount;
            if ($model->total_amount != $model->payment_amount) {
                $model->addError('payment_amount', 'Please enter exact "Payment amount!."');
            } elseif ($model->save())
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
        $dataProvider = new CActiveDataProvider('TimesheetPaymentDetailsForHospital');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TimesheetPaymentDetailsForHospital('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TimesheetPaymentDetailsForHospital']))
            $model->attributes = $_GET['TimesheetPaymentDetailsForHospital'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TimesheetPaymentDetailsForHospital the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = TimesheetPaymentDetailsForHospital::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TimesheetPaymentDetailsForHospital $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'timesheet-payment-details-for-hospital-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetTotalAmount() {
        $sqlQuery = "SELECT SUM(t.total_amount_of_hospital) FROM {{timesheet}} t WHERE t.week_end_date = '" . $_POST['weekEndDate'] . "' AND t.hospital_unit_id = '" . $_POST['hospital_id'] . "' GROUP BY t.week_end_date";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $li_result = 00.00;
        if (count($command) != 0)
            $li_result = $command[0]['SUM(t.total_amount_of_hospital)'];

        echo $li_result;
    }

}
