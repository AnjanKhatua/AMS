<?php

class HospitalJobTypeRateController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view', 'GetJobTypeForHospital'),
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
        $model = new HospitalJobTypeRate;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['HospitalJobTypeRate'])) {
//            $model->attributes = $_POST['HospitalJobTypeRate'];
            $post = $_POST;
            if ($_POST['HospitalJobTypeRate']['hospital_unit_id'] != "") {
                $sqlQuery = "SELECT h.hospital_unit_id FROM {{hospital_unit}} h WHERE h.hospital_unit = '" . $_POST['HospitalJobTypeRate']['hospital_unit_id'] . "'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();
            }

            $i = 0;
            if (($post['HospitalJobTypeRate']['hospital_unit_id'] != "") && ($post['HospitalJobTypeRate']['rate'] != "") && (count($post['HospitalJobTypeRate']['finance_job_type_id']) != 0)) {
                for ($i = 0; $i < count($post['HospitalJobTypeRate']['finance_job_type_id']); $i++) {
                    $model = new HospitalJobTypeRate;

                    $model->pay_rate_for_staffs = $post['HospitalJobTypeRate']['pay_rate_for_staffs'];
                    $model->rate = $post['HospitalJobTypeRate']['rate'];
                    $model->finance_job_type_id = $post['HospitalJobTypeRate']['finance_job_type_id'][$i];
                    $model->hospital_unit_id = $command['hospital_unit_id'];

                    $sqlQueryForDuplicateEntry = "SELECT * FROM {{hospital_job_type_rate_map}} WHERE `hospital_unit_id` = '" . $model->hospital_unit_id . "' AND `finance_job_type_id` = '" . $model->finance_job_type_id . "'";
                    $commandForDuplicateEntry = Yii::app()->db->createCommand($sqlQueryForDuplicateEntry)->queryAll();

                    if (count($commandForDuplicateEntry) == 0) {
                        $model->save();
                    } else {
                        $data = array(
                            "rate" => $post['HospitalJobTypeRate']['rate'],
                            "pay_rate_for_staffs" => $post['HospitalJobTypeRate']['pay_rate_for_staffs']
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_hospital_job_type_rate_map', $data, 'id=:id', array(':id' => $commandForDuplicateEntry[0]['id'])
                        );
                    }
                }
            } else {
                $model->hospital_unit_id = $command['hospital_unit_id'];
                if (count($_POST['HospitalJobTypeRate']['finance_job_type_id']) != 0)
                    $model->finance_job_type_id = $_POST['HospitalJobTypeRate']['finance_job_type_id'][0];
                $model->rate = $_POST['HospitalJobTypeRate']['rate'];
                $model->save();
                $model->finance_job_type_id = $_POST['HospitalJobTypeRate']['finance_job_type_id'];
            }
            if (isset($post['HospitalJobTypeRate']['finance_job_type_id']) && (count($post['HospitalJobTypeRate']['finance_job_type_id']) == $i)) {
                $ls_adminUrl = Yii::app()->createUrl('finance/HospitalJobTypeRate/admin');
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

        if (isset($_POST['HospitalJobTypeRate'])) {
            $model->attributes = $_POST['HospitalJobTypeRate'];

            $sqlQuery = "SELECT h.hospital_unit_id FROM {{hospital_unit}} h WHERE h.hospital_unit = '" . $_POST['HospitalJobTypeRate']['hospital_unit_id'] . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();

            $model->hospital_unit_id = $command['hospital_unit_id'];
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
        $dataProvider = new CActiveDataProvider('HospitalJobTypeRate');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new HospitalJobTypeRate('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HospitalJobTypeRate']))
            $model->attributes = $_GET['HospitalJobTypeRate'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return HospitalJobTypeRate the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = HospitalJobTypeRate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param HospitalJobTypeRate $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hospital-job-type-rate-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetJobTypeForHospital() {
        $sqlQueryForJobType = "SELECT j.job_type_id, j.job_type_name FROM {{job_type_for_finance}} j, {{hospital_job_type_rate_map}} hm WHERE j.job_type_id = hm.finance_job_type_id AND hm.hospital_unit_id = '" . $_POST['hospital_unit_id'] . "'";
        $commandForJobType = Yii::app()->db->createCommand($sqlQueryForJobType)->queryAll();
        
        $allJobType = '';
        foreach ($commandForJobType as $k => $lv_jobType) {
            $allJobType .=
                    '<option value="' . $lv_jobType['job_type_id'] . '">' . $lv_jobType['job_type_name'] . '</option>';
        }
        echo $allJobType;
    }

}
