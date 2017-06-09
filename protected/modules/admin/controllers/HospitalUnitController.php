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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'shiftDetails', 'eventCalendar', 'EventCalendarForShiftDetails', 'events', 'eventDetails'),
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
        if ($id == 0) {
            $this->render('event-calendar');
        } else {
            $this->render('event-calendar', array(
                'model' => $this->loadModel($id)
            ));
        }
    }

    /**
     * Displays a particular model with all booking of that shift
     * @param integer $id the ID of the model to be displayed
     */
    public function actionshiftDetails() {
        $sqlQueryForShiftId = "SELECT s.staff_request_id, s.quantity, s.quantity_confirmed, s.status, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime "
                . "FROM {{shift_management_for_hospital}} s, {{hospital_unit}} h "
                . "WHERE h.hospital_unit_id = s.hospital_unit_id AND s.shift_start_datetime LIKE '" . $_GET['date'] . "%'";
        if ($_GET['hospital_unit_id'] != 0) {
            $sqlQueryForShiftId .= " AND s.hospital_unit_id ='" . $_GET['hospital_unit_id'] . "'";
        }
        $sqlQueryForShiftId .= " ORDER BY h.hospital_unit";
        $commandForShiftId = Yii::app()->db->createCommand($sqlQueryForShiftId)->queryAll();

        $la_shiftDetails = array();
        $i = 0;
        foreach ($commandForShiftId as $value) { 
            $sqlQueryForStaffDetails = "SELECT CONCAT(u.first_name,' ', u.last_name) as `full_name`"
                    . "FROM {{user}} u "
                    . "LEFT JOIN {{booking}} b ON u.id = b.staff_id "
                    . "LEFT JOIN {{shift_management_for_hospital}} s ON b.staff_request_id = s.staff_request_id "
                    . "WHERE b.cancel_by_whom = 0 AND s.staff_request_id = '" . $value['staff_request_id'] . "' ORDER BY u.first_name";
            $commandForStaffDetails = Yii::app()->db->createCommand($sqlQueryForStaffDetails)->queryAll();

            $la_shiftDetails[$i]['hospital_unit'] = $value['hospital_unit'];
            $la_shiftDetails[$i]['shift_start_datetime'] = $value['shift_start_datetime'];
            $la_shiftDetails[$i]['status'] = $value['status'];
//            $la_shiftDetails[$i]['shift_end_datetime'] = $value['shift_end_datetime'];
//            $la_shiftDetails[$i]['quantity'] = $value['quantity'];
//            $la_shiftDetails[$i]['quantity_confirmed'] = $value['quantity_confirmed'];
            $ls_name = "";
            foreach ($commandForStaffDetails as $k => $ls_staffName) {
                if ($ls_name == '') {
                    $ls_name = $ls_staffName['full_name'];
                } else {
                    $ls_name .=', ' . $ls_staffName['full_name'];
                }
            }
            $la_shiftDetails[$i++]['booked_staff'] = $ls_name;
        }

        $this->render('shiftDetails', array(
            'model' => $la_shiftDetails
        ));
    }

    public function actionEvents() {
        $sqlQuery = "SELECT * FROM {{shift_management_for_hospital}}";
        if ($_GET['hospital_unit_id'] != 0) {
            $sqlQuery .= " WHERE `hospital_unit_id`='" . $_GET['hospital_unit_id'] . "'";
        }
        $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
        $events = array();
        $j = 0;
        
        /*
         * For marge all
         */
        $dates = array();
        $k = 0;
        for ($i = 0; $i < count($command); $i++) {
            $lv_shiftStartTime = substr($command[$i]['shift_start_datetime'], 11);

            $lv_shiftEndTime = substr($command[$i]['shift_end_datetime'], 11);

            $startDate = $command[$i]['shift_start_datetime'];
            $endDate = $command[$i]['shift_end_datetime'];

            $begin = new DateTime($startDate);
            $end = new DateTime($endDate);

            $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

            foreach ($daterange as $date) {
                if (!in_array($date->format("Y-m-d"), $dates))
                    $dates[$k++] = $date->format("Y-m-d");
            }
        }

        foreach ($dates as $value) {
            $title = "CHECK DAY WISE SHIFT";
            if ($_GET['hospital_unit_id'] == 0) {
                $id = 0;
                $event = array('title' => $title, 'start' => $value, 'end' => $value, 'backgroundColor' =>'black', 'textColor' =>'#ffff00', 'url' => Yii::app()->createUrl("admin/hospitalUnit/shiftDetails", array("hospital_unit_id" => $id, "date" => $value)));
            } else {
                $event = array('title' => $title, 'start' => $value, 'end' => $value, 'backgroundColor' =>'black', 'textColor' =>'#ffff00', 'url' => Yii::app()->createUrl("admin/hospitalUnit/shiftDetails", array("hospital_unit_id" => $_GET['hospital_unit_id'], "date" => $value)));
            }
            $events[$j++] = $event;
        }
        /*
         * End code
         */
        
        for ($i = 0; $i < count($command); $i++) {
            $start = explode(' ', $command[$i]['shift_start_datetime']);
            $end = explode(' ', $command[$i]['shift_end_datetime']);
            $staffRequestId = $command[$i]['staff_request_id'];
            
            $commandJob = Yii::app()->db->createCommand("SELECT job_type FROM {{job_type}} WHERE `job_type_id`='" . $command[$i]['job_type_id'] . "'")->queryAll();
            $jobName = $commandJob[0]['job_type'];
//            $title = Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]) . " (" . $jobName . "=" . $command[$i]['quantity_confirmed'] . "/" . $command[$i]['quantity'] . ")";
            
            if($command[$i]['status'] == 'Ar'){
                $lv_backColor = '#EA4335';
                $title = Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]) . " (Shift canceled)";
            }else{
                $lv_backColor = '#3A87AD';
                $title = Utility::changeTimeToUK($start[1]) . " to " . Utility::changeTimeToUK($end[1]) . " (" . $jobName . "=" . $command[$i]['quantity_confirmed'] . "/" . $command[$i]['quantity'] . ")";
            }
//            $event = array('title' => $title, 'start' => $start[0] . 'T' . $start[1], 'end' => $end[0] . 'T' . $end[1], 'url' => 'http://localhost/hospital-shift-schedule/index.php?r=admin/shiftManagementForHospital/booking&id=' . $command[$i]['staff_request_id']);
            $event = array('title' => $title, 'start' => $start[0] . 'T' . $start[1], 'end' => $end[0] . 'T' . $end[1], 'backgroundColor' =>$lv_backColor,  'url' => Yii::app()->createUrl("admin/shiftManagementForHospital/booking", array("id" => $staffRequestId)));
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

        $command = Yii::app()->db->createCommand("SELECT * FROM {{ward_hospital_unit_map}} WHERE `hospital_unit_id`=" . $id)->queryAll();
        foreach ($command as $li_dWard) {
            Yii::app()->db->createCommand()->delete('ams_ward_hospital_unit_map', 'id =' . $li_dWard['id']);
        }

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
