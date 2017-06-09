<?php

class ShiftEnquiryController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'AdminAck', 'delete', 'index', 'view', 'shiftApplyOrCancel'),
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
        $sqlQuery = "SELECT `staff_id` FROM {{shift_enquiry_ack}} WHERE `enquiry_id` = " . $id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        if ($command[0]['staff_id'] != $_SESSION['logged_user']['id']) {
            die('You are not authenticate for that action!');
        }

        $lo_model = $this->loadModel($id);
        /* For staff status conversation */
        $la_status = YII::app()->params['status'];
        $la_staffType = YII::app()->params['staffType'];

        foreach ($la_status as $x => $x_value) {
            if ($x == $lo_model->availability_confirmed_by_staff) {
                $lo_model->availability_confirmed_by_staff = $x_value;
            }
        }

        foreach ($la_status as $x => $x_value) {
            if ($x == $lo_model->is_confirmed) {
                $lo_model->is_confirmed = $x_value;
            }
        }

        foreach ($la_staffType as $x => $x_value) {
            if ($x == $lo_model->confirmed_by) {
                $lo_model->confirmed_by = $x_value;
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
        $model = new ShiftEnquiry;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ShiftEnquiry'])) {
            $model->attributes = $_POST['ShiftEnquiry'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->enquiry_id));
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
        $sqlQuery = "SELECT `staff_id` FROM {{shift_enquiry_ack}} WHERE `enquiry_id` = " . $id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        if ($command[0]['staff_id'] != $_SESSION['logged_user']['id']) {
            die('You are not authenticate for that action!');
        }

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ShiftEnquiry'])) {
            $model->attributes = $_POST['ShiftEnquiry'];
            $model->availability_confirmed_via = 'Dashboard';
            $model->confirmed_by = 'S';
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->enquiry_id));
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
        $dataProvider = new CActiveDataProvider('ShiftEnquiry');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ShiftEnquiry('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftEnquiry']))
            $model->attributes = $_GET['ShiftEnquiry'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminAck() {
        $model = new ShiftEnquiry('search_ack');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftEnquiry']))
            $model->attributes = $_GET['ShiftEnquiry'];

        $this->render('admin_ack', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ShiftEnquiry the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ShiftEnquiry::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ShiftEnquiry $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'shift-enquiry-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionshiftApplyOrCancel($id) {
        $actn = Utility::checkApplyStatus($id, $_SESSION[logged_user][id]);

        $data = array();
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `staff_request_id` = '" . $id . "'";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        $sqlQueryAll = "SELECT `hospital_unit`, `relevant_coordinator_id`, `address`, `job_type`, `ward_name` FROM {{hospital_unit}} h, {{job_type}} j, {{ward}} w WHERE `ward_id` = '" . $command[0]['ward_id'] . "' AND `job_type_id` = '" . $command[0]['job_type_id'] . "' AND `hospital_unit_id` = '" . $command[0]['hospital_unit_id'] . "'";
        $commandAll = Yii::app()->db->createCommand($sqlQueryAll)->queryAll();

        $data['staff_request_id'] = $id;
        $data['hospital_unit'] = $commandAll[0]['hospital_unit'];
        $data['address'] = $commandAll[0]['address'];
        $data['job_type'] = $commandAll[0]['job_type'];
        $data['ward_name'] = $commandAll[0]['ward_name'];
        $data['shift_start_datetime'] = Utility::changeDateToUK($command[0]['shift_start_datetime']);
        $data['shift_end_datetime'] = Utility::changeDateToUK($command[0]['shift_end_datetime']);
        $data['mobile'] =  $_SESSION['logged_user']['mobile'];
        $coordinator = Utility::getRelevantCoordinator($commandAll[0]['relevant_coordinator_id']);

        if ($actn == 1) {
            $modelQnquiry = new ShiftEnquiry;

            $modelQnquiry->staff_request_id = $id;
            $modelQnquiry->staff_id = $_SESSION['logged_user']['id'];
            $modelQnquiry->enquired_by = $_SESSION['logged_user']['id'];
            $modelQnquiry->availability_confirmed_by_staff = 'Y';
            $modelQnquiry->availability_confirmed_via = 'Dashboard';
            $modelQnquiry->confirmed_by = 'S';
            $modelQnquiry->agent_user_id = 0;
            $modelQnquiry->is_confirmed = 'N';
            if ($modelQnquiry->save()) {
                Utility::applyForShiftMail($data, $coordinator);
            }

            $ls_staffUpdatePageUrl = YII::app()->createUrl('staff/AvailableShiftForHospital/admin');
            header('Location:' . $ls_staffUpdatePageUrl);
            exit();
        } elseif ($actn == 0) {
            Yii::app()->db->createCommand()->delete('ams_shift_enquiry_ack', 'staff_id=:staff_id and staff_request_id=:staff_request_id', array(':staff_id' => $_SESSION[logged_user][id], ':staff_request_id' => $id));
            Utility::cancelShiftMail($data, $coordinator);
            $ls_staffUpdatePageUrl = YII::app()->createUrl('staff/AvailableShiftForHospital/admin');
            header('Location:' . $ls_staffUpdatePageUrl);
            exit();
        }
    }

}
