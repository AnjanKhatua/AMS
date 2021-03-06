<?php

class StaffJobTypeRateController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'cancel', 'index', 'view'),
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

        $model = new StaffJobTypeRate;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['StaffJobTypeRate'])) {
            $post = $_POST;

            if ($_POST['StaffJobTypeRate']['staff_id'] != "") {
                $userEmail = $_POST['StaffJobTypeRate']['staff_id'];
                $startValue = strrpos($userEmail, "(") + 1;
                $ls_email = substr($userEmail, $startValue, -1);
                $sqlQuery = "SELECT u.id FROM {{user}} u WHERE u.email = '" . $ls_email . "'";
                $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();
            }

            $i = 0;

            if (($post['StaffJobTypeRate']['staff_id'] != "") && ($post['StaffJobTypeRate']['rate'] != "") && (count($post['StaffJobTypeRate']['finance_job_type_id']) != 0)) {
                for ($i = 0; $i < count($post['StaffJobTypeRate']['finance_job_type_id']); $i++) {
                    $model = new StaffJobTypeRate;
//                    $model->attributes = $_POST['StaffJobTypeRate'];
                    $model->rate = $post['StaffJobTypeRate']['rate'];
                    $model->finance_job_type_id = $post['StaffJobTypeRate']['finance_job_type_id'][$i];
                    $model->staff_id = $command['id'];


                    $sqlQueryForDuplicateEntry = "SELECT * FROM {{staff_job_type_rate_map}} WHERE `staff_id` = '" . $model->staff_id . "' AND `finance_job_type_id` = '" . $model->finance_job_type_id . "'";
                    $commandForDuplicateEntry = Yii::app()->db->createCommand($sqlQueryForDuplicateEntry)->queryAll();

                    if (count($commandForDuplicateEntry) == 0) {
                        $model->save();
                    } else {
                        $data = array(
                            "rate" => $post['StaffJobTypeRate']['rate']
                        );
                        $update = Yii::app()->db->createCommand()
                                ->update('ams_staff_job_type_rate_map', $data, 'id=:id', array(':id' => $commandForDuplicateEntry[0]['id'])
                        );
                    }
                }
            } else {
                $model->staff_id = $command['id'];
                if (count($_POST['StaffJobTypeRate']['finance_job_type_id']) != 0)
                    $model->finance_job_type_id = $_POST['StaffJobTypeRate']['finance_job_type_id'][0];
                $model->rate = $_POST['StaffJobTypeRate']['rate'];
                $model->save();
                $model->finance_job_type_id = $_POST['StaffJobTypeRate']['finance_job_type_id'];
            }

            if (isset($post['StaffJobTypeRate']['finance_job_type_id']) && (count($post['StaffJobTypeRate']['finance_job_type_id']) == $i)) {
                $ls_adminUrl = Yii::app()->createUrl('finance/StaffJobTypeRate/admin');
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

        if (isset($_POST['StaffJobTypeRate'])) {
            $userEmail = $_POST['StaffJobTypeRate']['staff_id'];
            $startValue = strrpos($userEmail, "(") + 1;

            $ls_email = substr($userEmail, $startValue, -1);
            $sqlQuery = "SELECT u.id FROM {{user}} u WHERE u.email = '" . $ls_email . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();

            $model->attributes = $_POST['StaffJobTypeRate'];
            $model->staff_id = $command['id'];
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
        $dataProvider = new CActiveDataProvider('StaffJobTypeRate');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new StaffJobTypeRate('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StaffJobTypeRate']))
            $model->attributes = $_GET['StaffJobTypeRate'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StaffJobTypeRate the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StaffJobTypeRate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param StaffJobTypeRate $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'staff-job-type-rate-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
