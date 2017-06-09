<?php

class JobTypeForFinanceController extends Controller {

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
        $lo_model = $this->loadModel($id);
        
        $la_status = YII::app()->params['status'];

        foreach ($la_status as $x => $x_value) {
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
        $model = new JobTypeForFinance;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['JobTypeForFinance'])) {
            $model->attributes = $_POST['JobTypeForFinance'];
            $sqlQuery = "SELECT job_type FROM {{job_type}} WHERE `job_type_id` = '" . $model->job_type_id . "'";
            $command = Yii::app()->db->createCommand($sqlQuery)->queryRow();
            $ls_jobType = $command['job_type'] . "-";
            if ($model->job_type_name == $ls_jobType) {
                $model->job_type_name = "";
            }

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                if ($model->job_type_name == "") {
                    $model->job_type_name = $ls_jobType;
                }
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

        if (isset($_POST['JobTypeForFinance'])) {
            $model->attributes = $_POST['JobTypeForFinance'];
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
        $dataProvider = new CActiveDataProvider('JobTypeForFinance');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new JobTypeForFinance('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['JobTypeForFinance']))
            $model->attributes = $_GET['JobTypeForFinance'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return JobTypeForFinance the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = JobTypeForFinance::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param JobTypeForFinance $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'job-type-for-finance-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
