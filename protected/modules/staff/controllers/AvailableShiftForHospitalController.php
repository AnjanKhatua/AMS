<?php

class AvailableShiftForHospitalController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'index', 'view'),
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
        $la_available = array();
        $la_available = Utility::getAvailableDateTimeForStaff($_SESSION['logged_user']['id']);

        $la_availableJob = array();
        $la_availableJob = Utility::getAvailableJobTypeForStaff($_SESSION['logged_user']['staff_id']);

        if (!in_array($id, $la_available)) {
            die('You are not authenticate for that action!');
        }

        $sqlQuery = "SELECT `job_type_id` FROM {{shift_management_for_hospital}} WHERE `status` = 'A'  AND `staff_request_id` = " . $id;
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();

        if (!in_array($command[0]['job_type_id'], $la_availableJob)) {
            die('You are not authenticate for that action!');
        }

        $lo_model = $this->loadModel($id);
        /* For staff status conversation */
        $la_shiftType = YII::app()->params['shiftStatus'];

        foreach ($la_shiftType as $x => $x_value) {
            if ($x == $lo_model->status) {
                $lo_model->status = $x_value;
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
        $model = new AvailableShiftForHospital;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AvailableShiftForHospital'])) {
            $model->attributes = $_POST['AvailableShiftForHospital'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->staff_request_id));
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

        if (isset($_POST['AvailableShiftForHospital'])) {
            $model->attributes = $_POST['AvailableShiftForHospital'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->staff_request_id));
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
        $dataProvider = new CActiveDataProvider('AvailableShiftForHospital');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AvailableShiftForHospital('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AvailableShiftForHospital']))
            $model->attributes = $_GET['AvailableShiftForHospital'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AvailableShiftForHospital the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AvailableShiftForHospital::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AvailableShiftForHospital $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'available-shift-for-hospital-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
