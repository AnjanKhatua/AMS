<?php

class HospitalRegistrationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'admin', 'delete', 'deleteunit'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
					'actions'=>array('admin','deleteunit'),
					'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new HospitalRegistration;
        $modelunit = new HospitalUnit;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['HospitalRegistration'], $_POST['HospitalUnit']))
		{
			$model->attributes=$_POST['HospitalRegistration'];
		
			if($model->save()){
				$hospital_id  = Yii::app()->db->getLastInsertID();	
				
				if(count($_POST['HospitalUnit']['hospital_unit']) > 0) {
				
					for($i=0;$i<count($_POST['HospitalUnit']['hospital_unit']);$i++){	
					    $modelunit = new HospitalUnit;
						$modelunit->hospital_id = $hospital_id;			
						$modelunit->hospital_unit = $_POST['HospitalUnit']['hospital_unit'][$i];
						$modelunit->address = $_POST['HospitalUnit']['address'][$i];
						$modelunit->local_area_id = $_POST['HospitalUnit']['local_area_id'][$i];
						$modelunit->email = $_POST['HospitalUnit']['email'][$i];
						$modelunit->contact_number = $_POST['HospitalUnit']['contact_number'][$i];
						$modelunit->hospital_unit_active_status = $_POST['HospitalUnit']['hospital_unit_active_status'][$i];
						$valid=$modelunit->validate();
						//if($valid){
							$modelunit->save(false);
						//}
						
					}
				}
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,'modelunit' =>$modelunit
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		//HospitalUnit::model()->findByAttributes(array('hospital_id'=>'2'));
        $modelunit= Yii::app()->db->createCommand('select * from ams_hospital_unit where hospital_id='.$id)->queryAll();
		
		if(isset($_POST['HospitalRegistration']))
		{
			$model->attributes=$_POST['HospitalRegistration'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,'modelunit' =>$modelunit
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
        $ls_deleteUnit = "DELETE FROM {{hospital_unit}} WHERE hospital_id=".$id;
        YII::app()->db->createCommand($ls_deleteUnit)->execute();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteunit($id)
	{
		$ls_deleteUnit = "DELETE FROM {{hospital_unit}} WHERE hospital_unit_id=".$id;
		YII::app()->db->createCommand($ls_deleteUnit)->execute();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('HospitalRegistration');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new HospitalRegistration('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HospitalRegistration']))
			$model->attributes=$_GET['HospitalRegistration'];
			
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return HospitalRegistration the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=HospitalRegistration::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param HospitalRegistration $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='hospital-registration-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
