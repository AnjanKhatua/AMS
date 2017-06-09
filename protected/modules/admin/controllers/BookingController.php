<?php

class BookingController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'docDelete'),
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
        $lo_model = $this->loadModel($id);
        $lo_model->cancellation_date = Utility::changeDateToUK($lo_model->cancellation_date);
        /* For staff status conversation */
        $la_staffStatus = YII::app()->params['staffType'];

        foreach ($la_staffStatus as $x => $x_value) {
            if ($x == $lo_model->cancel_requested_by) {
                $lo_model->cancel_requested_by = $x_value;
            }
        }

        foreach ($la_staffStatus as $x => $x_value) {
            if ($x == $lo_model->confirm_by_whom) {
                $lo_model->confirm_by_whom = $x_value;
            }
        }

        $this->render('view', array(
            'model' => $lo_model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Booking;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Booking'])) {
            $model->attributes = $_POST['Booking'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->booking_id));
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

        if (isset($_POST['Booking'])) {
            $model->attributes = $_POST['Booking'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->booking_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actioncancel($id, $staffRequestId) {
        $model = $this->loadModel($id);
        $li_staff_id = $model->staff_id;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Booking'])) {
            $model->attributes = $_POST['Booking'];
            $model->cancellation_date = date("Y-m-d");
            $model->cancellation_time = date("H:i:s");
            $model->cancel_by_whom = $_SESSION['logged_user']['id'];
            if ($model->save()) {
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

//                $li_staff_id = $model->staff_id;

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
                $this->redirect(array('view', 'id' => $model->booking_id));
            }
        }

        $this->render('cancel', array(
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
        $dataProvider = new CActiveDataProvider('Booking');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Booking('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Booking']))
            $model->attributes = $_GET['Booking'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Booking the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Booking::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Booking $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'booking-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
