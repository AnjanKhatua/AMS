<?php

class ShiftEnquiryAckController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'index', 'confirm', 'view', 'docDelete'),
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
//    public function actionView($id) {
//        $this->render('view', array(
//            'model' => $this->loadModel($id),
//        ));
//    }
    public function actionView($id) {
        $lo_model = $this->loadModel($id);
        /* For staff status conversation */
        $la_staffStatus = YII::app()->params['staffType'];
        $la_status = YII::app()->params['status'];

        foreach ($la_staffStatus as $x => $x_value) {
            if ($x == $lo_model->confirmed_by) {
                $lo_model->confirmed_by = $x_value;
            }
        }

        foreach ($la_status as $x => $x_value) {
            if ($x == $lo_model->availability_confirmed_by_staff) {
                $lo_model->availability_confirmed_by_staff = $x_value;
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
        $model = new ShiftEnquiryAck;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ShiftEnquiryAck'])) {
            $model->attributes = $_POST['ShiftEnquiryAck'];
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ShiftEnquiryAck'])) {
            $model->attributes = $_POST['ShiftEnquiryAck'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->enquiry_id));
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
    public function actionconfirm($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ShiftEnquiryAck'])) {
            $model->attributes = $_POST['ShiftEnquiryAck'];
            $model->confirmed_by = $_SESSION['logged_user']['type'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->enquiry_id));
        }

        $this->render('confirm', array(
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
        $dataProvider = new CActiveDataProvider('ShiftEnquiryAck');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ShiftEnquiryAck('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ShiftEnquiryAck']))
            $model->attributes = $_GET['ShiftEnquiryAck'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ShiftEnquiryAck the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ShiftEnquiryAck::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ShiftEnquiryAck $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'shift-enquiry-ack-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
