<?php

class HospitalUnitController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'eventCalendar', 'EventCalendarForShiftDetails', 'events', 'eventDetails'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Event Calendar 
     */
    public function actionEventCalendar($id) {
        $this->layout = '//layouts/column3';
        $this->render('event-calendar', array(
            'model' => $this->loadModel($id)
        ));
    }

    /**
     * Event Calendar event-calendarForShiftDetails
     */
    public function actionEventCalendarForShiftDetails() {
        $this->layout = '//layouts/column2';
        $this->render('event-calendarForShiftDetails');
    }

    public function actionEvents() {
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}} WHERE `hospital_unit_id` = " . $_GET['hospital_unit_id'];
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $events = array();
        $j = 0;
        for ($i = 0; $i < count($command); $i++) {
            $start = explode(' ', $command[$i]['shift_start_datetime']);
            $end = explode(' ', $command[$i]['shift_end_datetime']);
            $staffRequestId = $command[$i]['staff_request_id'];
            $commandJob = Yii::app()->db->createCommand("SELECT job_type FROM {{job_type}} WHERE `job_type_id`='" . $command[$i]['job_type_id'] . "'")->queryAll();
            $jobName = $commandJob[0]['job_type'];
//            $title = Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]) . " (" . $jobName . "=" . $command[$i]['quantity_confirmed'] . "/" . $command[$i]['quantity'] . ")";
            $title = Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]) . " (" . $jobName . "=" . $command[$i]['quantity_confirmed'] . "/" . $command[$i]['quantity'] . ")";

//            $event = array('title' => $title, 'start' => $start[0] . 'T' . $start[1], 'end' => $end[0] . 'T' . $end[1], 'url' => 'http://localhost/hospital-shift-schedule/index.php?r=admin/shiftManagementForHospital/booking&id=' . $command[$i]['staff_request_id']);
            $event = array('title' => $title, 'start' => $start[0] . 'T' . $start[1], 'end' => $end[0] . 'T' . $end[1], 'url' => Yii::app()->createUrl("admin/shiftManagementForHospital/booking", array("id" => $staffRequestId)));
            $events[$j++] = $event;
        }
        echo json_encode($events);
    }

    public function actionEventDetails() {
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}}";
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $events = array();
        $j = 0;
        for ($i = 0; $i < count($command); $i++) {
            $start = explode(' ', $command[$i]['shift_start_datetime']);
            $end = explode(' ', $command[$i]['shift_end_datetime']);
            $staffRequestId = $command[$i]['staff_request_id'];
            $commandJob = Yii::app()->db->createCommand("SELECT job_type FROM {{job_type}} WHERE `job_type_id`='" . $command[$i]['job_type_id'] . "'")->queryAll();
            $jobName = $commandJob[0]['job_type'];

            $commandHospital = Yii::app()->db->createCommand("SELECT hospital_unit FROM {{hospital_unit}} WHERE `hospital_unit_id`='" . $command[$i]['hospital_unit_id'] . "'")->queryAll();
            $hospitalName = $commandHospital[0]['hospital_unit'];
//            $title = Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]) . " (" . $jobName . "=" . $command[$i]['quantity_confirmed'] . "/" . $command[$i]['quantity'] . ")";
//            $title = "Hospital : ".$hospitalName." [".Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]) . "] (" . $jobName . "=" . $command[$i]['quantity_confirmed'] . "/" . $command[$i]['quantity'] . ")";

            $title = $command[$i]['quantity_confirmed'] . "/" . $command[$i]['quantity'] . " " . $jobName . " allocated for " . $hospitalName . " from " . Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]);
//            $event = array('title' => $title, 'start' => $start[0] . 'T' . $start[1], 'end' => $end[0] . 'T' . $end[1], 'url' => 'http://localhost/hospital-shift-schedule/index.php?r=admin/shiftManagementForHospital/booking&id=' . $command[$i]['staff_request_id']);
            $event = array('title' => $title, 'start' => $start[0] . 'T' . $start[1], 'end' => $end[0] . 'T' . $end[1], 'url' => Yii::app()->createUrl("admin/shiftManagementForHospital/booking", array("id" => $staffRequestId)));
            $events[$j++] = $event;
        }
        echo json_encode($events);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $command = Yii::app()->db->createCommand("SELECT * FROM  {{ward_hospital_unit_map}}, {{ward}} WHERE {{ward_hospital_unit_map}}.hospital_unit_id = '" . $id . "' and {{ward_hospital_unit_map}}.ward_id={{ward}}.ward_id")->queryAll();
        $wards = $command[0]['ward_name'];
        for ($i = 1; $i < count($command); $i++) {
            $wards = $wards . "," . $command[$i]['ward_name'];
        }

        $this->render('view', array(
            'model' => $this->loadModel($id), 'wards' => $wards
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new HospitalUnit;
        $modelWardHospitalMap = new WardHospitalUnitMap;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);


        if (isset($_POST['HospitalUnit'])) {
            $ls_training = implode(", ", $_POST['HospitalUnit']['training_needed']);

            $model->hospital_id = $_POST['HospitalUnit']['hospital_id'];
            $model->hospital_unit = $_POST['HospitalUnit']['hospital_unit'];
            $model->address = $_POST['HospitalUnit']['address'];
            $model->local_area_id = $_POST['HospitalUnit']['local_area_id'];
            $model->training_needed = $ls_training;
            $model->hospital_email = $_POST['HospitalUnit']['hospital_email'];
            $model->contact_number = $_POST['HospitalUnit']['contact_number'];
            $model->relevant_coordinator_id = $_POST['HospitalUnit']['relevant_coordinator_id'];
            $model->hospital_unit_active_status = $_POST['HospitalUnit']['hospital_unit_active_status'];
            if ($model->save()) {
                $hospitalUnit_id = Yii::app()->db->getLastInsertID();
                for ($i = 0; $i < count($_POST['HospitalUnit']['wards']); $i++) {
                    $modelWardHospitalMap = new WardHospitalUnitMap;
                    $modelWardHospitalMap->ward_id = $_POST['HospitalUnit']['wards'][$i];
                    $modelWardHospitalMap->hospital_unit_id = $hospitalUnit_id;
                    $modelWardHospitalMap->save();
                }
                $this->redirect(array('admin'));
            }
            $model->wards = $_POST['HospitalUnit']['wards'];
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

        $command = Yii::app()->db->createCommand("SELECT * FROM  {{ward_hospital_unit_map}} WHERE {{ward_hospital_unit_map}}.hospital_unit_id='" . $id . "'")->queryAll();
        $wardsArray = array();

        for ($i = 0; $i < count($command); $i++) {
            array_push($wardsArray, $command[$i]['ward_id']);
        }

        $ls_training = explode(", ", $model->training_needed);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['HospitalUnit'])) {
            $model->attributes = $_POST['HospitalUnit'];
            $ls_training_needed = implode(", ", $_POST['HospitalUnit']['training_needed']);
            $model->training_needed = $ls_training_needed;
            if ($model->save()) {
                $model->wards = $_POST['HospitalUnit']['wards'];
                $command = Yii::app()->db->createCommand("SELECT * FROM {{ward_hospital_unit_map}} WHERE `hospital_unit_id`=" . $id)->queryAll();
                foreach ($command as $obj) {
                    Yii::app()->db->createCommand()->delete('ams_ward_hospital_unit_map', '`hospital_unit_id` =' . $obj['hospital_unit_id']);
                }

                for ($i = 0; $i < count($_POST['HospitalUnit']['wards']); $i++) {

                    $modelWardHospitalMap = new WardHospitalUnitMap;
                    $modelWardHospitalMap->ward_id = $_POST['HospitalUnit']['wards'][$i];
                    $modelWardHospitalMap->hospital_unit_id = $id;
                    $modelWardHospitalMap->save();
                }
                $this->redirect(array('view', 'id' => $model->hospital_unit_id));
            }
        }
        $model->wards = $wardsArray;
        $model->training_needed = $ls_training;

        $this->render('update', array(
            'model' => $model
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
        $dataProvider = new CActiveDataProvider('HospitalUnit');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new HospitalUnit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HospitalUnit']))
            $model->attributes = $_GET['HospitalUnit'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return HospitalUnit the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = HospitalUnit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param HospitalUnit $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hospital-unit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
