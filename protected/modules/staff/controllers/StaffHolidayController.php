<?php

class StaffHolidayController extends Controller {

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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new StaffHoliday;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);               
        $allData = array();
        $allBookingData = array();
        if (isset($_POST['StaffHoliday'])) {
            $model->attributes = $_POST['StaffHoliday'];
            $model->staff_id = $_SESSION['logged_user']['id'];
            if ($model->start_date != "") {
                $model->start_date = Utility::changeDateToMysql($model->start_date);
            }
            if ($model->end_date != "") {
                $model->end_date = Utility::changeDateToMysql($model->end_date);
            }

            if ($model->start_date != "" && $model->end_date != "") {
                $sqlQuery = "SELECT * FROM `ams_holiday` WHERE `staff_id` = '" . $_SESSION['logged_user']['id'] . "' AND `start_date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "'";
                $sqlQuery1 = "SELECT * FROM `ams_holiday` WHERE `staff_id` = '" . $_SESSION['logged_user']['id'] . "' AND `end_date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "'";
                $sqlQuery2 = "SELECT * FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND `staff_id` = '" . $_SESSION['logged_user']['id'] . "' AND `date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "' AND r.already_booked = 'Y'";

                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
                $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();


                if (count($command) != 0) {
                    $allData = $command;
                } elseif (count($command1) != 0) {
                    $allData = $command1;
                } elseif (count($command2) != 0) {
                    $allBookingData = $command2;
                }
            }
            if (count($allData) == 0 && count($allBookingData) == 0 ) {
                if ($model->save()) {
                    Utility::applyHolidayMail();
                    $this->redirect(array('view', 'id' => $model->holiday_id));
                } else {
                    if ($model->start_date != "") {
                        $model->start_date = Utility::changeDateToUK($model->start_date);
                    }
                    if ($model->end_date != "") {
                        $model->end_date = Utility::changeDateToUK($model->end_date);
                    }
                }
            } else {
                if ($model->start_date != "") {
                    $model->start_date = Utility::changeDateToUK($model->start_date);
                }
                if ($model->end_date != "") {
                    $model->end_date = Utility::changeDateToUK($model->end_date);
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'chkData' => $allData,
            'chkData1' => $allBookingData,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{holiday}} WHERE `holiday_id`=" . $id)->queryAll();
        if (count($command) != 0) {
            $chkModel = $this->loadModel($id);
            if ((!isset($chkModel)) || ($chkModel->staff_id != $_SESSION['logged_user']['id'])) {
                die('You are not authenticate for that action!');
            }
        } else {
            die('You are not authenticate for that action!');
        }

        $model = $this->loadModel($id);

        if ($model->start_date != "") {
            $model->start_date = Utility::changeDateToUK($model->start_date);
        }
        if ($model->end_date != "") {
            $model->end_date = Utility::changeDateToUK($model->end_date);
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $allData = array();
        if (isset($_POST['StaffHoliday'])) {
            $model->attributes = $_POST['StaffHoliday'];
            $model->staff_id = $_SESSION['logged_user']['id'];
            if ($model->start_date != "") {
                $model->start_date = Utility::changeDateToMysql($model->start_date);
            }
            if ($model->end_date != "") {
                $model->end_date = Utility::changeDateToMysql($model->end_date);
            }

            if ($model->start_date != "" && $model->end_date != "") {
                $sqlQuery = "SELECT * FROM `ams_holiday` WHERE `staff_id` = '" . $_SESSION['logged_user']['id'] . "' AND `holiday_id` != '" . $model->holiday_id . "' AND `start_date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "'";
                $sqlQuery1 = "SELECT * FROM `ams_holiday` WHERE `staff_id` = '" . $_SESSION['logged_user']['id'] . "' AND `holiday_id` != '" . $model->holiday_id . "' AND `end_date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "'";
                $sqlQuery2 = "SELECT * FROM {{regular_non_availability_of_staff}} r, {{non_availability_of_staff}} n WHERE r.non_availablility_id = n.non_availablility_id AND `staff_id` = '" . $_SESSION['logged_user']['id'] . "' AND `date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "' AND r.already_booked = 'Y'";

                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
                $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();


                if (count($command) != 0) {
                    $allData = $command;
                } elseif (count($command1) != 0) {
                    $allData = $command1;
                } elseif (count($command2) != 0) {
                    $allBookingData = $command2;
                }
            }
            if (count($allData) == 0 && count($allBookingData) == 0 ) {
                if ($model->save()) {
                    Utility::applyHolidayMail();
                    $this->redirect(array('view', 'id' => $model->holiday_id));
                } else {
                    if ($model->start_date != "") {
                        $model->start_date = Utility::changeDateToUK($model->start_date);
                    }
                    if ($model->end_date != "") {
                        $model->end_date = Utility::changeDateToUK($model->end_date);
                    }
                }
            } else {
                if ($model->start_date != "") {
                    $model->start_date = Utility::changeDateToUK($model->start_date);
                }
                if ($model->end_date != "") {
                    $model->end_date = Utility::changeDateToUK($model->end_date);
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'chkData' => $allData,
            'chkData1' => $allBookingData,
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
        $dataProvider = new CActiveDataProvider('StaffHoliday');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new StaffHoliday('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffHoliday']))
            $model->attributes = $_GET['StaffHoliday'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StaffHoliday the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StaffHoliday::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param StaffHoliday $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'staff-holiday-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
