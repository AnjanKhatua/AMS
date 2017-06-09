<?php

class StaffRegistrationController extends Controller {

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
                'actions' => array('ExportStaffDetails', 'SendSMSOrMail', 'SendAllSMSOrMail', 'create', 'update', 'admin', 'AdminDraft', 'AdminSuspended', 'AdminInactive', 'AdminArchive', 'delete', 'index', 'view', 'docDelete'),
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

        $model = new StaffRegistration;
        $get_Area = $model->getArea($id);
        $get_Job = $model->getJobType($id);
        $lo_model = $this->loadModel($id);
        /* For staff status conversation */
        $la_staffStatus = YII::app()->params['staffStatus'];

        foreach ($la_staffStatus as $x => $x_value) {
            if ($x == $lo_model->staff_status) {
                $lo_model->staff_status = $x_value;
            }
        }

        /*
         * @Change date (YYYY-MM-DD) to (DD-MM-YYYY)
         */
        $lo_model->start_date = Utility::changeDateToUK($lo_model->start_date);
        $lo_model->date_of_birth = Utility::changeDateToUK($lo_model->date_of_birth);
        $lo_model->passport_issue_date = Utility::changeDateToUK($lo_model->passport_issue_date);
        $lo_model->passport_expiry_date = Utility::changeDateToUK($lo_model->passport_expiry_date);
        $lo_model->visa_issue_date = Utility::changeDateToUK($lo_model->visa_issue_date);
        $lo_model->visa_expiry_date = Utility::changeDateToUK($lo_model->visa_expiry_date);
        $lo_model->date_of_incorporation = Utility::changeDateToUK($lo_model->date_of_incorporation);
        $lo_model->dbs_issue_date = Utility::changeDateToUK($lo_model->dbs_issue_date);
        $lo_model->dbs_expiry = Utility::changeDateToUK($lo_model->dbs_expiry);
        $lo_model->last_dbs_check = Utility::changeDateToUK($lo_model->last_dbs_check);
        $lo_model->mandatory_training_expiry_date = Utility::changeDateToUK($lo_model->mandatory_training_expiry_date);
        $lo_model->pmva_expiry_date = Utility::changeDateToUK($lo_model->pmva_expiry_date);
        $lo_model->maybo_training_expiry = Utility::changeDateToUK($lo_model->maybo_training_expiry);
        $lo_model->mapa_expiry_date = Utility::changeDateToUK($lo_model->mapa_expiry_date);
        $lo_model->pin_expiry_date = Utility::changeDateToUK($lo_model->pin_expiry_date);
        $lo_model->re_validation_renewal_date = Utility::changeDateToUK($lo_model->re_validation_renewal_date);
        $lo_model->medication_assessment_completed_date = Utility::changeDateToUK($lo_model->medication_assessment_completed_date);

        $this->render('view', array(
            'model' => $lo_model,
            'areaAll' => $get_Area,
            'jobAll' => $get_Job,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new StaffRegistration;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['StaffRegistration'])) {
            $model->attributes = $_POST['StaffRegistration'];
            if (isset($_POST['workAreaMap']['area']))
                $model->area = $_POST['workAreaMap']['area'];

            if (isset($_POST['staffJobTypeMap']['job_type']))
                $model->job_type = $_POST['staffJobTypeMap']['job_type'];
            /*
             * @Change date (DD-MM-YYYY) to (YYYY-MM-DD)
             */
            if ($model->start_date != "") {
                $model->start_date = Utility::changeDateToMysql($model->start_date);
            }
            if ($model->date_of_birth != "") {
                $model->date_of_birth = Utility::changeDateToMysql($model->date_of_birth);
            }
            if ($model->passport_issue_date != "") {
                $model->passport_issue_date = Utility::changeDateToMysql($model->passport_issue_date);
            }
            if ($model->passport_expiry_date != "") {
                $model->passport_expiry_date = Utility::changeDateToMysql($model->passport_expiry_date);
            }
            if ($model->visa_issue_date != "") {
                $model->visa_issue_date = Utility::changeDateToMysql($model->visa_issue_date);
            }
            if ($model->visa_expiry_date != "") {
                $model->visa_expiry_date = Utility::changeDateToMysql($model->visa_expiry_date);
            }
            if ($model->date_of_incorporation != "") {
                $model->date_of_incorporation = Utility::changeDateToMysql($model->date_of_incorporation);
            }
            if ($model->dbs_issue_date != "") {
                $model->dbs_issue_date = Utility::changeDateToMysql($model->dbs_issue_date);
            }
            if ($model->dbs_expiry != "") {
                $model->dbs_expiry = Utility::changeDateToMysql($model->dbs_expiry);
            }
            if ($model->last_dbs_check != "") {
                $model->last_dbs_check = Utility::changeDateToMysql($model->last_dbs_check);
            }
            if ($model->mandatory_training_expiry_date != "") {
                $model->mandatory_training_expiry_date = Utility::changeDateToMysql($model->mandatory_training_expiry_date);
            }
            if ($model->pmva_expiry_date != "") {
                $model->pmva_expiry_date = Utility::changeDateToMysql($model->pmva_expiry_date);
            }
            if ($model->maybo_training_expiry != "") {
                $model->maybo_training_expiry = Utility::changeDateToMysql($model->maybo_training_expiry);
            }
            if ($model->mapa_expiry_date != "") {
                $model->mapa_expiry_date = Utility::changeDateToMysql($model->mapa_expiry_date);
            }
            if ($model->pin_expiry_date != "") {
                $model->pin_expiry_date = Utility::changeDateToMysql($model->pin_expiry_date);
            }
            if ($model->re_validation_renewal_date != "") {
                $model->re_validation_renewal_date = Utility::changeDateToMysql($model->re_validation_renewal_date);
            }
            if ($model->medication_assessment_completed_date != "") {
                $model->medication_assessment_completed_date = Utility::changeDateToMysql($model->medication_assessment_completed_date);
            }


            $ls_nationality = Utility::formatInput($model->nationality);

            if (strtolower($ls_nationality) == "british") {
                $model->visa_expiry_date = $model->passport_expiry_date;
            }
            /*
             * @Scenario set for Draft
             */

            if ($model->staff_status != 'D' && $model->staff_status != 'Ar')
                $model->scenario = 'exceptDraftArchieve';

            if (StaffRegistration::model()->checkUserEmail($model->email) == 0) {
                $model->addError('email', 'Email id "' . $model->email . '" has already been taken as user');
            } else {
                if ($model->save()) {

                    if ($model->staff_status == 'A') {
                        Utility::staffStatusMail($model->staff_status, $model->email, $model->mobile_no, $model->first_name);
                    }
                    /*
                     * @Selected area saving
                     */
                    if (isset($_POST['workAreaMap']['area'])) {
                        foreach ($_POST['workAreaMap']['area'] as $k => $lo_area) {
                            $modelWorkArea = new StaffRegistrationPreferredWorkAreaMapTable;
                            $modelWorkArea->staff_id = $model->staff_id;
                            $modelWorkArea->work_area_id = $lo_area;
                            $modelWorkArea->save();
                        }
                    }

                    if (isset($_POST['staffJobTypeMap']['job_type'])) {
                        foreach ($_POST['staffJobTypeMap']['job_type'] as $k => $li_job_type) {
                            $modelJobType = new StaffJobTypeMap;
                            $modelJobType->staff_id = $model->staff_id;
                            $modelJobType->job_type_id = $li_job_type;
                            $modelJobType->save();
                        }
                    }

                    $modelUser = new User;
                    $modelUser->first_name = $model->first_name;
                    $modelUser->last_name = $model->last_name;
                    $modelUser->gender = $model->gender;
                    $modelUser->email = $model->email;
                    $modelUser->date_of_birth = $model->date_of_birth;
                    $ld_dateOfBirth = $model->date_of_birth;
                    $ld_dateOfBirth = date('dmY', strtotime($ld_dateOfBirth));
                    $modelUser->password = md5($ld_dateOfBirth);
                    $modelUser->mobile = $model->mobile_no;
                    $modelUser->address = $model->address_1;
                    $modelUser->type = 'S';
                    $modelUser->staff_id = $model->staff_id;
                    $modelUser->active_status = 'Y';

                    $la_profileImage = YII::app()->params['profileImage'];

                    foreach ($la_profileImage as $x => $x_value) {
                        if ($x == $modelUser->gender) {
                            $modelUser->image = $x_value;
                        }
                    }

                    if ($_FILES['image']['name'] != "") {
                        $rnd = time();
                        $fileNameImage = $rnd . "-" . $_FILES['image']['name']; // random number + file name
                        $modelUser->image = $fileNameImage;
                        $destdir = Yii::app()->basePath . '/../userImage/';
                        move_uploaded_file($_FILES['image']['tmp_name'], $destdir . $fileNameImage);
                    }

                    if ($model->staff_status == 'D' || $model->staff_status == 'Ar') {
                        $modelUser->active_status = 'N';
                    } else {
                        $modelUser->scenario = 'exceptDraftArchieve';
                    }
                    $modelUser->save();

                    if (isset($_POST['docType'])) {
                        $length = count($_POST['docType']);

                        for ($i = 0; $i < $length; $i++) {
                            $staffDoc = new StaffDocument;
                            $staffDoc->staff_id = $model->staff_id;
                            $staffDoc->document_header_id = $_POST['docType'][$i];
                            $staffDoc->document_name = $_FILES['fileName']['name'][$i];

                            if ($staffDoc->document_name != "") {
                                $rnd = time();
                                $fileNameImage = $rnd . "-" . $_FILES['fileName']['name'][$i]; // random number + file name
                                $staffDoc->document_name = $fileNameImage;
                                $destdir = Yii::app()->basePath . '/../staffDocuments/';
                                move_uploaded_file($_FILES['fileName']['tmp_name'][$i], $destdir . $fileNameImage);
                                $staffDoc->save();
                            }
                        }
                    }

                    $this->redirect(array('view', 'id' => $model->staff_id));
                }
            }

            if ($model->start_date != "") {
                $model->start_date = Utility::changeDateToUK($model->start_date);
            }
            if ($model->date_of_birth != "") {
                $model->date_of_birth = Utility::changeDateToUK($model->date_of_birth);
            }
            if ($model->passport_issue_date != "") {
                $model->passport_issue_date = Utility::changeDateToUK($model->passport_issue_date);
            }
            if ($model->passport_expiry_date != "") {
                $model->passport_expiry_date = Utility::changeDateToUK($model->passport_expiry_date);
            }
            if ($model->visa_issue_date != "") {
                $model->visa_issue_date = Utility::changeDateToUK($model->visa_issue_date);
            }
            if ($model->visa_expiry_date != "") {
                $model->visa_expiry_date = Utility::changeDateToUK($model->visa_expiry_date);
            }
            if ($model->date_of_incorporation != "") {
                $model->date_of_incorporation = Utility::changeDateToUK($model->date_of_incorporation);
            }
            if ($model->dbs_issue_date != "") {
                $model->dbs_issue_date = Utility::changeDateToUK($model->dbs_issue_date);
            }
            if ($model->dbs_expiry != "") {
                $model->dbs_expiry = Utility::changeDateToUK($model->dbs_expiry);
            }
            if ($model->last_dbs_check != "") {
                $model->last_dbs_check = Utility::changeDateToUK($model->last_dbs_check);
            }
            if ($model->mandatory_training_expiry_date != "") {
                $model->mandatory_training_expiry_date = Utility::changeDateToUK($model->mandatory_training_expiry_date);
            }
            if ($model->pmva_expiry_date != "") {
                $model->pmva_expiry_date = Utility::changeDateToUK($model->pmva_expiry_date);
            }
            if ($model->maybo_training_expiry != "") {
                $model->maybo_training_expiry = Utility::changeDateToUK($model->maybo_training_expiry);
            }
            if ($model->mapa_expiry_date != "") {
                $model->mapa_expiry_date = Utility::changeDateToUK($model->mapa_expiry_date);
            }
            if ($model->pin_expiry_date != "") {
                $model->pin_expiry_date = Utility::changeDateToUK($model->pin_expiry_date);
            }
            if ($model->re_validation_renewal_date != "") {
                $model->re_validation_renewal_date = Utility::changeDateToUK($model->re_validation_renewal_date);
            }
            if ($model->medication_assessment_completed_date != "") {
                $model->medication_assessment_completed_date = Utility::changeDateToUK($model->medication_assessment_completed_date);
            }
        }
//        print_r($model);die;
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
        $modelOld = $this->loadModel($id);

        $documents = Yii::app()->db->createCommand("SELECT * FROM {{staff_document}} WHERE `staff_id` = " . $id)->queryAll();
        $documentTypes = Yii::app()->db->createCommand("SELECT * FROM {{document_header}}")->queryAll();

        if ($model->start_date != "") {
            $model->start_date = Utility::changeDateToUK($model->start_date);
        }
        if ($model->date_of_birth != "") {
            $model->date_of_birth = Utility::changeDateToUK($model->date_of_birth);
        }
        if ($model->passport_issue_date != "") {
            $model->passport_issue_date = Utility::changeDateToUK($model->passport_issue_date);
        }
        if ($model->passport_expiry_date != "") {
            $model->passport_expiry_date = Utility::changeDateToUK($model->passport_expiry_date);
        }
        if ($model->visa_issue_date != "") {
            $model->visa_issue_date = Utility::changeDateToUK($model->visa_issue_date);
        }
        if ($model->visa_expiry_date != "") {
            $model->visa_expiry_date = Utility::changeDateToUK($model->visa_expiry_date);
        }
        if ($model->date_of_incorporation != "") {
            $model->date_of_incorporation = Utility::changeDateToUK($model->date_of_incorporation);
        }
        if ($model->dbs_issue_date != "") {
            $model->dbs_issue_date = Utility::changeDateToUK($model->dbs_issue_date);
        }
        if ($model->dbs_expiry != "") {
            $model->dbs_expiry = Utility::changeDateToUK($model->dbs_expiry);
        }
        if ($model->last_dbs_check != "") {
            $model->last_dbs_check = Utility::changeDateToUK($model->last_dbs_check);
        }
        if ($model->mandatory_training_expiry_date != "") {
            $model->mandatory_training_expiry_date = Utility::changeDateToUK($model->mandatory_training_expiry_date);
        }
        if ($model->pmva_expiry_date != "") {
            $model->pmva_expiry_date = Utility::changeDateToUK($model->pmva_expiry_date);
        }
        if ($model->maybo_training_expiry != "") {
            $model->maybo_training_expiry = Utility::changeDateToUK($model->maybo_training_expiry);
        }
        if ($model->mapa_expiry_date != "") {
            $model->mapa_expiry_date = Utility::changeDateToUK($model->mapa_expiry_date);
        }
        if ($model->pin_expiry_date != "") {
            $model->pin_expiry_date = Utility::changeDateToUK($model->pin_expiry_date);
        }
        if ($model->re_validation_renewal_date != "") {
            $model->re_validation_renewal_date = Utility::changeDateToUK($model->re_validation_renewal_date);
        }
        if ($model->medication_assessment_completed_date != "") {
            $model->medication_assessment_completed_date = Utility::changeDateToUK($model->medication_assessment_completed_date);
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['StaffRegistration'])) {
//            print_r($_POST);print_r($_FILES);die;
            $model->attributes = $_POST['StaffRegistration'];
//            wDebug::debugObject($model,'',1);die;

            if ($model->start_date != "") {
                $model->start_date = Utility::changeDateToMysql($model->start_date);
            }
            if ($model->date_of_birth != "") {
                $model->date_of_birth = Utility::changeDateToMysql($model->date_of_birth);
            }
            if ($model->passport_issue_date != "") {
                $model->passport_issue_date = Utility::changeDateToMysql($model->passport_issue_date);
            }
            if ($model->passport_expiry_date != "") {
                $model->passport_expiry_date = Utility::changeDateToMysql($model->passport_expiry_date);
            }
            if ($model->visa_issue_date != "") {
                $model->visa_issue_date = Utility::changeDateToMysql($model->visa_issue_date);
            }
            if ($model->visa_expiry_date != "") {
                $model->visa_expiry_date = Utility::changeDateToMysql($model->visa_expiry_date);
            }
            if ($model->last_dbs_check != "") {
                $model->last_dbs_check = Utility::changeDateToMysql($model->last_dbs_check);
            }
            if ($model->date_of_incorporation != "") {
                $model->date_of_incorporation = Utility::changeDateToMysql($model->date_of_incorporation);
            }
            if ($model->dbs_issue_date != "") {
                $model->dbs_issue_date = Utility::changeDateToMysql($model->dbs_issue_date);
            }
            if ($model->dbs_expiry != "") {
                $model->dbs_expiry = Utility::changeDateToMysql($model->dbs_expiry);
            }
            if ($model->mandatory_training_expiry_date != "") {
                $model->mandatory_training_expiry_date = Utility::changeDateToMysql($model->mandatory_training_expiry_date);
            }
            if ($model->pmva_expiry_date != "") {
                $model->pmva_expiry_date = Utility::changeDateToMysql($model->pmva_expiry_date);
            }
            if ($model->maybo_training_expiry != "") {
                $model->maybo_training_expiry = Utility::changeDateToMysql($model->maybo_training_expiry);
            }
            if ($model->mapa_expiry_date != "") {
                $model->mapa_expiry_date = Utility::changeDateToMysql($model->mapa_expiry_date);
            }
            if ($model->pin_expiry_date != "") {
                $model->pin_expiry_date = Utility::changeDateToMysql($model->pin_expiry_date);
            }
            if ($model->re_validation_renewal_date != "") {
                $model->re_validation_renewal_date = Utility::changeDateToMysql($model->re_validation_renewal_date);
            }
            if ($model->medication_assessment_completed_date != "") {
                $model->medication_assessment_completed_date = Utility::changeDateToMysql($model->medication_assessment_completed_date);
            }

            $ls_nationality = Utility::formatInput($model->nationality);

            if (strtolower($ls_nationality) == "british") {
                $model->visa_expiry_date = $model->passport_expiry_date;
            }

            if ($model->staff_status != 'D' && $model->staff_status != 'Ar')
                $model->scenario = 'exceptDraftArchieve';


            if (isset($_POST['staffJobTypeMap']['job_type'])) {
                $model->job_type = count($_POST['staffJobTypeMap']['job_type']);
            }

            if (isset($_POST['workAreaMap']['area'])) {
                $model->area = count($_POST['workAreaMap']['area']);
            }

            if (StaffRegistration::model()->checkUserEmail($model->email, $model->staff_id) == 0) {
                $model->addError('email', 'Email id "' . $model->email . '" has already been taken as user');
            } else {
                if ($model->save()) {
                    if ($modelOld->staff_status != $model->staff_status) {
                        Utility::staffStatusMail($model->staff_status, $model->email, $model->mobile_no, $model->first_name);
                    }
                    if (isset($_POST['workAreaMap']['area'])) {
                        foreach ($_POST['workAreaMap']['area'] as $k => $li_area) {
                            $modelWorkArea = new StaffRegistrationPreferredWorkAreaMapTable;
                            $modelWorkArea->staff_id = $model->staff_id;
                            $modelWorkArea->work_area_id = $li_area;

                            $la_workArea = Yii::app()->db->createCommand()
                                    ->select('staff_id, work_area_id')
                                    ->from('ams_staff_registration_preferred_work_area_map_table')
                                    ->where('staff_id=:staff_id and work_area_id=:work_area_id', array(':staff_id' => $model->staff_id, ':work_area_id' => $li_area))
                                    ->queryRow();
                            if (!$la_workArea)
                                $modelWorkArea->save();
                        }
                    }

                    $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_registration_preferred_work_area_map_table}} WHERE `staff_id`=" . $model->staff_id)->queryAll();
                    foreach ($command as $li_dArea) {
                        if (!in_array($li_dArea['work_area_id'], $_POST['workAreaMap']['area'])) {
                            Yii::app()->db->createCommand()->delete('ams_staff_registration_preferred_work_area_map_table', 'id =' . $li_dArea['id']);
                        }
                    }

                    if (isset($_POST['staffJobTypeMap']['job_type'])) {
                        foreach ($_POST['staffJobTypeMap']['job_type'] as $k => $li_job_type) {
                            $modelJobType = new StaffJobTypeMap;
                            $modelJobType->staff_id = $model->staff_id;
                            $modelJobType->job_type_id = $li_job_type;

                            $la_job_type = Yii::app()->db->createCommand()
                                    ->select('staff_id, job_type_id')
                                    ->from('ams_staff_job_type_map')
                                    ->where('staff_id=:staff_id and job_type_id=:job_type_id', array(':staff_id' => $model->staff_id, ':job_type_id' => $li_job_type))
                                    ->queryRow();
                            if (!$la_job_type)
                                $modelJobType->save();
                        }
                    }

                    $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_job_type_map}} WHERE `staff_id`=" . $model->staff_id)->queryAll();
                    foreach ($command as $li_dJobType) {
                        if (!in_array($li_dJobType['job_type_id'], $_POST['staffJobTypeMap']['job_type'])) {
                            Yii::app()->db->createCommand()->delete('ams_staff_job_type_map', 'id =' . $li_dJobType['id']);
                        }
                    }

                    if (isset($_POST['docType'])) {
                        $length = count($_POST['docType']);

                        for ($i = 0; $i < $length; $i++) {
                            $staffDoc = new StaffDocument;
                            $staffDoc->staff_id = $model->staff_id;
                            $staffDoc->document_header_id = $_POST['docType'][$i];
                            $staffDoc->document_name = $_FILES['fileName']['name'][$i];

                            $oldimage = "";
                            $command = Yii::app()->db->createCommand("SELECT document_name FROM {{staff_document}} WHERE `document_header_id` = " . $staffDoc->document_header_id . " and  `staff_id` = " . $model->staff_id)->queryAll();
                            foreach ($command as $k => $lv_fileName) {
                                $oldimage = $lv_fileName['document_name'];
                            }

                            if ($staffDoc->document_name != "") {
                                if ($oldimage != "")
                                    @unlink(Yii::app()->basePath . '/../staffDocuments/' . $oldimage);
                                $rnd = time();
                                $fileNameImage = $rnd . "-" . $_FILES['fileName']['name'][$i]; // random number + file name
                                $staffDoc->document_name = $fileNameImage;

                                if ($oldimage != "") {
                                    $data = array(
                                        "staff_id" => $staffDoc->staff_id,
                                        "document_header_id" => $staffDoc->document_header_id,
                                        "document_name" => $staffDoc->document_name
                                    );
                                    $update = Yii::app()->db->createCommand()
                                            ->update('ams_staff_document', $data, 'staff_id=:staff_id and document_header_id=:document_header_id', array(':staff_id' => $model->staff_id, ':document_header_id' => $staffDoc->document_header_id)
                                    );
                                    $destdir = Yii::app()->basePath . '/../staffDocuments/';
                                    move_uploaded_file($_FILES['fileName']['tmp_name'][$i], $destdir . $fileNameImage);
                                } else {
                                    $destdir = Yii::app()->basePath . '/../staffDocuments/';
                                    move_uploaded_file($_FILES['fileName']['tmp_name'][$i], $destdir . $fileNameImage);
                                    $staffDoc->save();
                                }
                            }
                        }
                    }

                    /* START: INSERT user in user table if does not exist; else update */


                    $command = Yii::app()->db->createCommand("SELECT `image` FROM {{user}} WHERE `staff_id` = " . $model->staff_id)->queryAll();

                    if (count($command) != 0) {
                        $modelUser = new User;
                        $modelUser->active_status = 'Y';
                        if ($model->staff_status == 'D' || $model->staff_status == 'Ar') {
                            $modelUser->active_status = 'N';
                        } else {
                            $modelUser->scenario = 'exceptDraftArchieve';
                        }
                        foreach ($command as $k => $lv_fileName) {
                            $oldProfileimage = $lv_fileName['image'];
                        }

                        $la_profileImage = YII::app()->params['profileImage'];
                        if ($modelOld->gender != $model->gender) {
                            foreach ($la_profileImage as $x => $x_value) {
                                if ($x == $model->gender) {
                                    $modelUser->image = $x_value;

                                    if ($_FILES['image']['name'] != "") {
                                        if ($oldProfileimage != "1666-male.jpg" && $model->gender == "Male") {
                                            @unlink(Yii::app()->basePath . '/../userImage/' . $oldProfileimage);
                                        }

                                        if ($model->gender == "Female" && $oldProfileimage != "2043-female.png") {
                                            @unlink(Yii::app()->basePath . '/../userImage/' . $oldProfileimage);
                                        }

                                        $rnd = time();
                                        $fileNameImage = $rnd . "-" . $_FILES['image']['name']; // random number + file name
                                        $modelUser->image = $fileNameImage;

                                        if ($modelUser->image != "") {
                                            $data = array(
                                                "first_name" => $model->first_name,
                                                "last_name" => $model->last_name,
                                                "gender" => $model->gender,
                                                "email" => $model->email,
                                                "date_of_birth" => $model->date_of_birth,
                                                "mobile" => $model->mobile_no,
                                                "address" => $model->address_1,
                                                "type" => 'S',
                                                "staff_id" => $model->staff_id,
                                                "image" => $modelUser->image,
                                                "active_status" => $modelUser->active_status
                                            );
                                            $update = Yii::app()->db->createCommand()
                                                    ->update('ams_user', $data, 'staff_id=:staff_id', array(':id' => $model->staff_id)
                                            );

                                            $destdir = Yii::app()->basePath . '/../userImage/';
                                            move_uploaded_file($_FILES['image']['tmp_name'], $destdir . $fileNameImage);
                                        }
                                    } else {
                                        $data = array(
                                            "first_name" => $model->first_name,
                                            "last_name" => $model->last_name,
                                            "gender" => $model->gender,
                                            "email" => $model->email,
                                            "date_of_birth" => $model->date_of_birth,
                                            "mobile" => $model->mobile_no,
                                            "address" => $model->address_1,
                                            "type" => 'S',
                                            "staff_id" => $model->staff_id,
                                            "active_status" => $modelUser->active_status
                                        );
                                        $update = Yii::app()->db->createCommand()
                                                ->update('ams_user', $data, 'staff_id=:staff_id', array(':id' => $model->staff_id)
                                        );
                                    }
                                }
                            }
                        } else {
                            if ($_FILES['image']['name'] != "") {
                                if ($oldProfileimage != "1666-male.jpg" && $model->gender == "Male") {
                                    @unlink(Yii::app()->basePath . '/../userImage/' . $oldProfileimage);
                                }

                                if ($model->gender == "Female" && $oldProfileimage != "2043-female.png") {
                                    @unlink(Yii::app()->basePath . '/../userImage/' . $oldProfileimage);
                                }

                                if ($oldProfileimage != "1666-male.jpg" && $oldProfileimage != "2043-female.png") {
                                    @unlink(Yii::app()->basePath . '/../userImage/' . $oldProfileimage);
                                }

                                $rnd = time();
                                $fileNameImage = $rnd . "-" . $_FILES['image']['name']; // random number + file name
                                $modelUser->image = $fileNameImage;

                                if ($modelUser->image != "") {
                                    $data = array(
                                        "first_name" => $model->first_name,
                                        "last_name" => $model->last_name,
                                        "gender" => $model->gender,
                                        "email" => $model->email,
                                        "date_of_birth" => $model->date_of_birth,
                                        "mobile" => $model->mobile_no,
                                        "address" => $model->address_1,
                                        "type" => 'S',
                                        "staff_id" => $model->staff_id,
                                        "image" => $modelUser->image,
                                        "active_status" => $modelUser->active_status
                                    );
                                    $update = Yii::app()->db->createCommand()
                                            ->update('ams_user', $data, 'staff_id=:staff_id', array(':id' => $model->staff_id)
                                    );

                                    $destdir = Yii::app()->basePath . '/../userImage/';
                                    move_uploaded_file($_FILES['image']['tmp_name'], $destdir . $fileNameImage);
                                }
                            } else {
                                $data = array(
                                    "first_name" => $model->first_name,
                                    "last_name" => $model->last_name,
                                    "gender" => $model->gender,
                                    "email" => $model->email,
                                    "date_of_birth" => $model->date_of_birth,
                                    "mobile" => $model->mobile_no,
                                    "address" => $model->address_1,
                                    "type" => 'S',
                                    "staff_id" => $model->staff_id,
                                    "active_status" => $modelUser->active_status
                                );
                                $update = Yii::app()->db->createCommand()
                                        ->update('ams_user', $data, 'staff_id=:staff_id', array(':id' => $model->staff_id)
                                );
                            }
                        }
                    } else {
                        $modelUser = new User;
                        $modelUser->first_name = $model->first_name;
                        $modelUser->last_name = $model->last_name;
                        $modelUser->gender = $model->gender;
                        $modelUser->email = $model->email;
                        $modelUser->date_of_birth = $model->date_of_birth;
                        $ld_dateOfBirth = $model->date_of_birth;
                        $ld_dateOfBirth = date('dmY', strtotime($ld_dateOfBirth));
                        $modelUser->password = md5($ld_dateOfBirth);
                        $modelUser->mobile = $model->mobile_no;
                        $modelUser->address = $model->address_1;
                        $modelUser->type = 'S';
                        $modelUser->staff_id = $model->staff_id;
                        $modelUser->active_status = 'Y';

                        $la_profileImage = YII::app()->params['profileImage'];

                        foreach ($la_profileImage as $x => $x_value) {
                            if ($x == $modelUser->gender) {
                                $modelUser->image = $x_value;
                            }
                        }
                        $modelUser->save();
                    }

                    /* END: user table insert/update coding */
                }

                if (count($model->getErrors()) == 0) {
                    $this->redirect(array('view', 'id' => $model->staff_id));
                }
            }
        }

        $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_registration_preferred_work_area_map_table}} WHERE `staff_id`=" . $model->staff_id)->queryAll();
        $la_area = array();
        $key = 0;
        foreach ($command as $lo_user) {
            $value = $lo_user['work_area_id'];
            $la_area[$key++] = $value;
        }
        $model->area = $la_area;

        $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_job_type_map}} WHERE `staff_id`=" . $model->staff_id)->queryAll();
        $la_jobType = array();
        $key = 0;
        foreach ($command as $lo_user) {
            $value = $lo_user['job_type_id'];
            $la_jobType[$key++] = $value;
        }
        $model->job_type = $la_jobType;

        $this->render('update', array(
            'model' => $model,
            'allFiles' => $documents,
            'docTypes' => $documentTypes,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if ($_SESSION[logged_user][type] != 'M' && $_SESSION[logged_user][type] != 'C') {
            $this->loadModel($id)->delete();

            $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_job_type_map}} WHERE `staff_id`=" . $id)->queryAll();
            foreach ($command as $li_dJobType) {
                Yii::app()->db->createCommand()->delete('ams_staff_job_type_map', 'id =' . $li_dJobType['id']);
            }

            $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_document}} WHERE `staff_id`=" . $id)->queryAll();
            foreach ($command as $li_dDoc) {
                @unlink(Yii::app()->basePath . '/../staffDocuments/' . $li_dDoc['document_name']);
                Yii::app()->db->createCommand()->delete('ams_staff_document', 'document_id =' . $li_dDoc['document_id']);
            }

            $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_registration_preferred_work_area_map_table}} WHERE `staff_id`=" . $id)->queryAll();
            foreach ($command as $li_dArea) {
                Yii::app()->db->createCommand()->delete('ams_staff_registration_preferred_work_area_map_table', 'id =' . $li_dArea['id']);
            }

            Yii::app()->db->createCommand()->delete('ams_user', 'staff_id =' . $id);
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }else {
            $data = array(
                "staff_status" => 'Ar'
            );
            $update = Yii::app()->db->createCommand()
                    ->update('ams_staff_registration', $data, 'staff_id=:staff_id', array(':staff_id' => $id)
            );
            $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/StaffRegistration/admin');
            header('Location:' . $ls_staffUpdatePageUrl);
            exit();
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('StaffRegistration');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new StaffRegistration('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffRegistration']))
            $model->attributes = $_GET['StaffRegistration'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminDraft() {
        $model = new StaffRegistration('search_draft');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffRegistration']))
            $model->attributes = $_GET['StaffRegistration'];

        $this->render('admin_draft', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminSuspended() {
        $model = new StaffRegistration('search_suspended');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffRegistration']))
            $model->attributes = $_GET['StaffRegistration'];

        $this->render('admin_suspended', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminInactive() {
        $model = new StaffRegistration('search_inactive');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffRegistration']))
            $model->attributes = $_GET['StaffRegistration'];

        $this->render('admin_inactive', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminArchive() {
        $model = new StaffRegistration('search_archive');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffRegistration']))
            $model->attributes = $_GET['StaffRegistration'];

        $this->render('admin_archive', array(
            'model' => $model,
        ));
    }

//$lo_model =  $this->loadModel($id);
//        $lo_model->start_date = Utility::changeDateToUK($lo_model->start_date);
//        $this->render('view', array(
//            'model' =>$lo_model ,
//        ));
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StaffRegistration the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StaffRegistration::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param StaffRegistration $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'staff-registration-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actiondocDelete($documentId) {
        $modelDocument = StaffDocument::model()->findByPk($documentId);

        $li_staffId = $modelDocument->staff_id;
        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/staffRegistration/update', array('id' => $li_staffId));
        @unlink(Yii::app()->basePath . '/../staffDocuments/' . $modelDocument->document_name);

        Yii::app()->db->createCommand()->delete('{{staff_document}}', 'document_id =' . $modelDocument->document_id);
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

    public function actionExportStaffDetails() {
        $ls_sqlColumn = "SELECT group_concat(CONCAT( UCASE( LEFT( COLUMN_NAME, 1 ) ) , SUBSTRING( COLUMN_NAME, 2 ) )) columns
                            FROM `INFORMATION_SCHEMA`.`COLUMNS`
                        WHERE `TABLE_NAME` = '{{staff_registration}}'";

        /* $ls_sql ="SELECT  SR.* FROM {{staff_registration}} SR"
          . ", (SELECT group_concat(JT.job_type) FROM {{job_type}} JT LEFT JOIN {{staff_job_type_map}} SJTMAP ON SJTMAP.job_type_id = JT.job_type_id ) AS job_type  WHERE staff_id = SR.staff_id "
          . "  ORDER BY SR.staff_status1"; 8/
         * 
         */
        $ls_sql = "SELECT  SR.*, GROUP_CONCAT(distinct JT.job_type) jobTypeName, GROUP_CONCAT(distinct WA.area_name) areaName
                           FROM {{staff_registration}} SR 
                     LEFT JOIN {{staff_job_type_map}} SJTMAP 
                        ON SR.staff_id = SJTMAP.staff_id
                     LEFT JOIN {{job_type}} JT 
                            ON SJTMAP.job_type_id = JT.job_type_id
                     LEFT JOIN {{staff_registration_preferred_work_area_map_table}}  PWAMAP
                        ON SR.staff_id = PWAMAP.staff_id
                     LEFT JOIN {{work_area}} WA
                        ON PWAMAP.work_area_id = WA.work_area_id
                     GROUP BY SR.staff_id";


        $la_resultCoulmn = Yii::app()->db->createCommand($ls_sqlColumn)->queryScalar() or die(mysql_error());


        $la_result[0] = explode(',', $la_resultCoulmn);
        $la_result[0][] = 'Job Type';
        $la_result[0][] = 'Preferred Work Area';

        $la_resultData = Yii::app()->db->createCommand($ls_sql)->queryAll() or die(mysql_error());
        foreach ($la_resultData as $info) {
            $la_result[] = $info;
        }

        Utility::convertToCsv($la_result, 'staff_details.csv', ',');
    }

    public function actionSendSMSOrMail($id, $email, $mobile) {
        $ls_startDate = date("Y-m-d H:i:s", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 1 day"));
        $ls_endDate = date("Y-m-d H:i:s", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 31 day"));

        if ($email != "") {
            $sqlQueryForReminder = "SELECT u.first_name, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND b.cancel_by_whom = 0 AND  u.staff_id = '" . $id . "' AND s.shift_start_datetime BETWEEN '" . $ls_startDate . "' AND '" . $ls_endDate . "' ORDER BY s.shift_start_datetime";
            $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

            $data = array();
            $ls_reminder = '';
            foreach ($commandForReminder AS $lv_reminder) {
                $data['first_name'] = $lv_reminder['first_name'];
                $ls_reminder.= 'at <b>' . $lv_reminder["hospital_unit"] . '</b> on <b>' . Utility::changeDateToUK($lv_reminder["shift_start_datetime"]) . '</b> to <b>' . Utility::changeTimeFromDateToUK($lv_reminder["shift_end_datetime"]) . '</b><br>';
            }
            $data['email'] = $email;
            $data['reminder'] = $ls_reminder;
            Utility::reminderMail($data);
        } elseif ($mobile != "") {
            $sqlQueryForReminder = "SELECT u.first_name, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND b.cancel_by_whom = 0 AND u.staff_id = '" . $id . "' AND s.shift_start_datetime BETWEEN '" . $ls_startDate . "' AND '" . $ls_endDate . "' ORDER BY s.shift_start_datetime";
            $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

            $data = array();
            $ls_reminder = '';
            foreach ($commandForReminder AS $lv_reminder) {
                $data['first_name'] = $lv_reminder['first_name'];
                if ($ls_reminder != "")
                    $ls_reminder.= ', %0a';
                $ls_reminder.= 'at ' . $lv_reminder["hospital_unit"] . ' on ' . Utility::changeDateToUK($lv_reminder["shift_start_datetime"]) . ' to ' . Utility::changeTimeFromDateToUK($lv_reminder["shift_end_datetime"]);
            }
            $data['mobile'] = $mobile;
            $data['reminder'] = $ls_reminder;
            Utility::reminderSMS($data);
        }
    }

    public function actionSendAllSMSOrMail($action) {
        $ls_startDate = date("Y-m-d H:i:s", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 1 day"));
        $ls_endDate = date("Y-m-d H:i:s", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+ 7 day"));

        if ($action == "mail") {
            $sqlQueryForReminder = "SELECT u.first_name, u.mobile, u.email, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime "
                    . "FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} sr "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND u.staff_id = sr.staff_id "
                    . "AND b.cancel_by_whom = 0 AND sr.staff_status = 'A' AND s.shift_start_datetime BETWEEN '" . $ls_startDate . "' AND '" . $ls_endDate . "' "
                    . "ORDER BY s.shift_start_datetime";
            $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

            $sqlQueryForReminderEmail = "SELECT u.email "
                    . "FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} sr "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND u.staff_id = sr.staff_id "
                    . "AND sr.staff_status = 'A' AND b.cancel_by_whom = 0 AND s.shift_start_datetime BETWEEN '" . $ls_startDate . "' AND '" . $ls_endDate . "' "
                    . "GROUP BY u.email ORDER BY s.shift_start_datetime";
            $commandForReminderEmail = Yii::app()->db->createCommand($sqlQueryForReminderEmail)->queryAll();

            foreach ($commandForReminderEmail AS $lv_email) {
                $data = array();
                $ls_reminder = '';
                foreach ($commandForReminder AS $lv_details) {
                    if ($lv_email['email'] == $lv_details['email']) {
                        $data['first_name'] = $lv_details['first_name'];
                        $ls_reminder.= 'at <b>' . $lv_details["hospital_unit"] . '</b> on <b>' . Utility::changeDateToUK($lv_details["shift_start_datetime"]) . '</b> to <b>' . Utility::changeTimeFromDateToUK($lv_details["shift_end_datetime"]) . '</b><br>';
                    }
                }
                $data['email'] = $lv_email['email'];
                $data['reminder'] = $ls_reminder;
                Utility::reminderMail($data);
            }
        } elseif ($action == "sms") {
            $sqlQueryForReminder = "SELECT u.first_name, u.mobile, u.email, h.hospital_unit, s.shift_start_datetime, s.shift_end_datetime "
                    . "FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} sr "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND u.staff_id = sr.staff_id "
                    . "AND sr.staff_status = 'A' AND b.cancel_by_whom = 0 AND s.shift_start_datetime BETWEEN '" . $ls_startDate . "' AND '" . $ls_endDate . "' "
                    . "ORDER BY s.shift_start_datetime";
            $commandForReminder = Yii::app()->db->createCommand($sqlQueryForReminder)->queryAll();

            $sqlQueryForReminderEmail = "SELECT u.first_name, u.email, u.mobile "
                    . "FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} sr "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND u.staff_id = sr.staff_id "
                    . "AND sr.staff_status = 'A' AND b.cancel_by_whom = 0 AND s.shift_start_datetime BETWEEN '" . $ls_startDate . "' AND '" . $ls_endDate . "' "
                    . "GROUP BY u.email ORDER BY s.shift_start_datetime";
            $commandForReminderEmail = Yii::app()->db->createCommand($sqlQueryForReminderEmail)->queryAll();

            $sqlQueryForReminderHospital = "SELECT h.hospital_unit "
                    . "FROM {{user}} u, {{shift_management_for_hospital}} s, {{booking}} b, {{hospital_unit}} h, {{staff_registration}} sr "
                    . "WHERE h.hospital_unit_id = s.hospital_unit_id AND u.id = b.staff_id AND s.staff_request_id = b.staff_request_id AND u.staff_id = sr.staff_id "
                    . "AND sr.staff_status = 'A' AND b.cancel_by_whom = 0 AND s.shift_start_datetime BETWEEN '" . $ls_startDate . "' AND '" . $ls_endDate . "' "
                    . "GROUP BY h.hospital_unit ORDER BY s.shift_start_datetime";
            $commandForReminderHospital = Yii::app()->db->createCommand($sqlQueryForReminderHospital)->queryAll();

//            foreach ($commandForReminderEmail AS $lv_mobile) {
//                $data = array();
//                $ls_reminder = '';
//                foreach ($commandForReminder AS $lv_details) {
//                    if ($lv_mobile['email'] == $lv_details['email']) {
//                        $data['first_name'] = $lv_details['first_name'];
//                        $ls_reminder.= ' at ' . $lv_details["hospital_unit"] . ' on ' . Utility::changeDateToUK($lv_details["shift_start_datetime"]) . ' to ' . Utility::changeTimeFromDateToUK($lv_details["shift_end_datetime"]);
//                    }
//                }
//                $data['mobile'] = $lv_mobile['mobile'];
//                $data['reminder'] = $ls_reminder;
//                Utility::reminderSMS($data);
//            }
//            print_r($commandForReminderEmail);
//            print_r($commandForReminderHospital);
//            print_r($commandForReminder);
            foreach ($commandForReminderEmail AS $lv_mobile) {
                $data = array();
                $ls_reminder = '';
                $data['first_name'] = $lv_mobile['first_name'];
                foreach ($commandForReminderHospital AS $lv_hospitalDetails) {
//                    $ls_prevHospitalName = $lv_hospitalDetails['hospital_unit'];
                    $ls_prevHospitalNameCount = 0;
                    foreach ($commandForReminder AS $lv_details) {
                        if (($lv_mobile['email'] == $lv_details['email']) && ($lv_hospitalDetails['hospital_unit'] == $lv_details['hospital_unit'])) {

                            if ($ls_prevHospitalNameCount != 1) {
                                $ls_prevHospitalNameCount = 1;
                                $ls_reminder .= 'at ' . $lv_details["hospital_unit"];
                            }
                            $ls_reminder .= ' on ' . Utility::changeDateToUK($lv_details["shift_start_datetime"]) . ' '
                                    . 'to ' . Utility::changeTimeFromDateToUK($lv_details["shift_end_datetime"]) . '; ';
                        }
                    }
                }

                $data['mobile'] = $lv_mobile['mobile'];
                $data['reminder'] = $ls_reminder;
                Utility::reminderSMS($data);
            }
        }
        $ls_staffUpdatePageUrl = YII::app()->createUrl('admin/StaffRegistration/admin');
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

}
