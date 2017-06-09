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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'GetTotalAmount', 'GetTrainingDeduction'),
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

            if ($model->total_amount == ($model->for_training_deduction + $model->payment_amount)) {
                $ls_getTimesheetId = "SELECT t.id FROM {{timesheet}} t WHERE t.week_end_date = '" . $model->week_end_date . "' AND t.staff_id = '" . $model->staff_id . "'";
                $commandFor_getTimesheetId = Yii::app()->db->createCommand($ls_getTimesheetId)->queryAll();

                if (count($commandFor_getTimesheetId) != 0) {
                    foreach ($commandFor_getTimesheetId as $value) {
                        $data = array(
                            "paid_to_staff" => 'Y'
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_timesheet', $data, 'id=:id', array(':id' => $value['id'])
                        );
                    }
                }

                $ls_getSqlQueryForTrainingDetails = "SELECT * FROM {{training_details}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.remaining_amount > 0";
                $commandFor_getSqlQueryForTrainingDetails = Yii::app()->db->createCommand($ls_getSqlQueryForTrainingDetails)->queryAll();

                $li_forTrainingDeductionAmount = $model->for_training_deduction;
                if (count($commandFor_getSqlQueryForTrainingDetails) != 0) {
                    foreach ($commandFor_getSqlQueryForTrainingDetails as $value) {

//                        if ($li_forTrainingDeductionAmount < $value['deduction_amount']) {
//                            $li_amount = $value['remaining_amount'] - $li_forTrainingDeductionAmount;
//                            $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $li_forTrainingDeductionAmount;
//                        } else {
//                            $li_amount = $value['remaining_amount'] - $value['deduction_amount'];
//                            $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $value['deduction_amount'];
//                        }
                        if ($value['deduction_amount'] <= $value['remaining_amount']) {
                            if ($li_forTrainingDeductionAmount < $value['deduction_amount']) {
                                $li_amount = $value['remaining_amount'] - $li_forTrainingDeductionAmount;
                                $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $li_forTrainingDeductionAmount;
                            } else {
                                $li_amount = $value['remaining_amount'] - $value['deduction_amount'];
                                $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $value['deduction_amount'];
                            }
                        }else{
                            if ($li_forTrainingDeductionAmount < $value['remaining_amount']) {
                                $li_amount = $value['remaining_amount'] - $li_forTrainingDeductionAmount;
                                $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $li_forTrainingDeductionAmount;
                            } else {
                                $li_amount = $value['remaining_amount'] - $value['remaining_amount'];
                                $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $value['remaining_amount'];
                            }
                        }

                        $data = array(
                            "remaining_amount" => $li_amount
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                        );
                    }
                }
            }
            $model->remaining_amount = $model->total_amount - ($model->for_training_deduction + $model->payment_amount);
            if ($model->total_amount != ($model->for_training_deduction + $model->payment_amount)) {
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

        if (isset($_POST['TimesheetPaymentDetailsForStaff'])) {
            $model->attributes = $_POST['TimesheetPaymentDetailsForStaff'];

            if ($model->total_amount == ($model->for_training_deduction + $model->payment_amount)) {
                $ls_getTimesheetId = "SELECT t.id FROM {{timesheet}} t WHERE t.week_end_date = '" . $model->week_end_date . "' AND t.staff_id = '" . $model->staff_id . "'";
                $commandFor_getTimesheetId = Yii::app()->db->createCommand($ls_getTimesheetId)->queryAll();

                if (count($commandFor_getTimesheetId) != 0) {
                    foreach ($commandFor_getTimesheetId as $value) {
                        $data = array(
                            "paid_to_staff" => 'Y'
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_timesheet', $data, 'id=:id', array(':id' => $value['id'])
                        );
                    }
                }

                $ls_getSqlQueryForTrainingDetails = "SELECT * FROM {{training_details}} t WHERE t.staff_id ='" . $model->staff_id . "' AND t.remaining_amount > 0";
                $commandFor_getSqlQueryForTrainingDetails = Yii::app()->db->createCommand($ls_getSqlQueryForTrainingDetails)->queryAll();

                $li_forTrainingDeductionAmount = $model->for_training_deduction;
                if (count($commandFor_getSqlQueryForTrainingDetails) != 0) {
                    foreach ($commandFor_getSqlQueryForTrainingDetails as $value) {
                        if ($li_forTrainingDeductionAmount < $value['deduction_amount']) {
                            $li_amount = $value['remaining_amount'] - $li_forTrainingDeductionAmount;
                            $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $li_forTrainingDeductionAmount;
                        } else {
                            $li_amount = $value['remaining_amount'] - $value['deduction_amount'];
                            $li_forTrainingDeductionAmount = $li_forTrainingDeductionAmount - $value['deduction_amount'];
                        }
                        $data = array(
                            "remaining_amount" => $li_amount
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_training_details', $data, 'id=:id', array(':id' => $value['id'])
                        );
                    }
                }
            }
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

    public function actionGetTotalAmount() {
        $sqlQuery = "SELECT SUM(t.total_amount_of_staff) FROM {{timesheet}} t WHERE t.week_end_date = '" . $_POST['weekEndDate'] . "' AND t.staff_id = '" . $_POST['staff_id'] . "' GROUP BY t.week_end_date";
//        $sqlQuery = "SELECT SUM(t.total_amount) FROM {{timesheet_payment_details_for_staff}} t WHERE t.week_end_date = '" . $_POST['weekEndDate'] . "' AND t.staff_id = '" . $_POST['staff_id'] . "' GROUP BY t.week_end_date";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $li_result = 00.00;
        if (count($command) != 0)
            $li_result = $command[0]['SUM(t.total_amount_of_staff)'];

        echo $li_result;
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
