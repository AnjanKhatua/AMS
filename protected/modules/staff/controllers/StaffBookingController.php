<?php

class StaffBookingController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'AdminPrevious', 'AdminCancel', 'ViewPrevious', 'ViewCancel', 'delete', 'index', 'view'),
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
        $la_available = Utility::getUpcomingBookingForStaff($_SESSION['logged_user']['id']);
            if (!in_array($id, $la_available)) {
                die('You are not authenticate for that action!');
            }
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }
    
     /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewPrevious($id) {
        $la_available = array();
        $la_available = Utility::getPreviousBookingForStaff($_SESSION['logged_user']['id']);
            if (!in_array($id, $la_available)) {
                die('You are not authenticate for that action!');
            }
        $this->render('view_previous', array(
            'model' => $this->loadModel($id),
        ));
    }
    
         /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
        public function actionViewCancel($id) {
        $lo_model = $this->loadModel($id);
        $la_available = array();
        $la_staffStatus = YII::app()->params['staffType'];

        foreach ($la_staffStatus as $x => $x_value) {
            if ($x == $lo_model->cancel_requested_by) {
                $lo_model->cancel_requested_by = $x_value;
            }
        }
        $la_available = Utility::getCancelledBookingForStaff($_SESSION['logged_user']['id']);
            if (!in_array($id, $la_available)) {
                die('You are not authenticate for that action!');
            }
        $this->render('view_cancel', array(
            'model' => $lo_model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new StaffBooking;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['StaffBooking'])) {
            $model->attributes = $_POST['StaffBooking'];
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

        if (isset($_POST['StaffBooking'])) {
            $model->attributes = $_POST['StaffBooking'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->booking_id));
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
        $dataProvider = new CActiveDataProvider('StaffBooking');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new StaffBooking('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffBooking']))
            $model->attributes = $_GET['StaffBooking'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminPrevious() {
        $model = new StaffBooking('search_previous');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffBooking']))
            $model->attributes = $_GET['StaffBooking'];

        $this->render('admin_previous', array(
            'model' => $model,
        ));
    }
    
     /**
     * Manages all models.
     */
    public function actionAdminCancel() {
        $model = new StaffBooking('search_cancel');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffBooking']))
            $model->attributes = $_GET['StaffBooking'];

        $this->render('admin_cancel', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StaffBooking the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StaffBooking::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param StaffBooking $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'staff-booking-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
