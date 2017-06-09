<?php

class UploadedTimesheetByStaffController extends Controller {

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
        $model = new UploadedTimesheetByStaff;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);


        if (isset($_POST['UploadedTimesheetByStaff'])) {
            if (isset($_POST['UploadedTimesheetByStaff']['week_end_date'])) {
                $length = count($_POST['UploadedTimesheetByStaff']['week_end_date']);

                $la_fileDetails = array();
                $j = 0;

                for ($i = 0; $i < $length; $i++) {
                    $model = new UploadedTimesheetByStaff;
                    $model->staff_id = $_SESSION['logged_user']['id'];
                    $model->ip = $_SERVER['REMOTE_ADDR'];
                    $model->week_end_date = $_POST['UploadedTimesheetByStaff']['week_end_date'][$i];
                    $model->upload_date_time = date("Y-m-d h:i:s");
                    $model->timesheet_name = $_FILES['timesheet_name']['name'][$i];

                    if ($model->timesheet_name != "") {
                        $rnd = time();
                        $fileNameImage = $rnd . "-" . $_FILES['timesheet_name']['name'][$i]; // random number + file name
                        $la_fileDetails[$j]['week_end_date'] = Utility::changeDateToUK($model->week_end_date);
                        $la_fileDetails[$j++]['timesheet'] = $fileNameImage;
                        $model->timesheet_name = $fileNameImage;
                        $destdir = Yii::app()->basePath . '/../staffTimesheet/';
                        move_uploaded_file($_FILES['timesheet_name']['tmp_name'][$i], $destdir . $fileNameImage);
                        $model->save();
                    }
                }

                $la_staffStatus = YII::app()->params['timesheetEmail'];
                $to = $la_staffStatus['email'];
                $subject = 'Timesheet from ' . $_SESSION['logged_user']['first_name'] . ' for ';
                $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: <" . $_SESSION['logged_user']['email'] . ">" . "\r\n";
                $message = '<p><h2>Hi,</h2></p><p>' . $_SESSION['logged_user']['first_name'] . ' has sent <span>the following timesheets given below : </span></p>';

                $li_count = count($la_fileDetails);
                $k = 0;
                foreach ($la_fileDetails as $value) {
                    if ($k == 0) {
                        $k++;
                        $subject .= $value['week_end_date'];
                    } else {
                        $k++;
                        $subject .= ', '.$value['week_end_date'] . " ";
                    }
                    $url = Yii::app()->getBaseUrl(true) . "/staffTimesheet/" . $value['timesheet'];
                    $message.='<table cellspacing="0" cellpadding="0"> <tr>';
                    $message .= '<td align="center" width="300" height="40" bgcolor="#4f27d2" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">';
                    $message .= '<a href="' . $url . '" style="color: #ffffff; font-size:16px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">Download ' . $value['week_end_date'] . ' timesheet!</a>';
                    $message .= '</td> </tr> </table>';
                    $message .= '<br>';
                }

                mail($to, $subject, $message, $headers);
            }

            if ($length == $i) {
                $ls_adminUrl = Yii::app()->createUrl('staff/UploadedTimesheetByStaff/admin');
                header('Location:' . $ls_adminUrl);
                exit();
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['UploadedTimesheetByStaff'])) {
            $model->attributes = $_POST['UploadedTimesheetByStaff'];
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
        $dataProvider = new CActiveDataProvider('UploadedTimesheetByStaff');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new UploadedTimesheetByStaff('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UploadedTimesheetByStaff']))
            $model->attributes = $_GET['UploadedTimesheetByStaff'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UploadedTimesheetByStaff the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UploadedTimesheetByStaff::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UploadedTimesheetByStaff $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'uploaded-timesheet-by-staff-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
