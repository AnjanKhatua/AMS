<?php

class NonAvailabilityController extends Controller {

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
        $model = new NonAvailability;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $allData = array();
        $allBookingData = array();
        $allNotBookingData = array();
        if (isset($_POST['NonAvailability'])) {
            $model->attributes = $_POST['NonAvailability'];
            $model->staff_id = $_SESSION['logged_user']['id'];
            if ($model->start_date != "") {
                $model->start_date = Utility::changeDateToMysql($model->start_date);
            }
            if ($model->end_date != "") {
                $model->end_date = Utility::changeDateToMysql($model->end_date);
            }

            if ($model->start_date != "" && $model->end_date != "") {
                $sqlQuery = "SELECT {{regular_non_availability_of_staff}}.non_availablility_id, `staff_id`, {{non_availability_of_staff}}.already_booked, `date`, {{regular_non_availability_of_staff}}.start_time, {{regular_non_availability_of_staff}}.end_time FROM {{regular_non_availability_of_staff}}, {{non_availability_of_staff}} WHERE {{regular_non_availability_of_staff}}.non_availablility_id = {{non_availability_of_staff}}.non_availablility_id AND {{non_availability_of_staff}}.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "' AND '" . $model->start_time . "'  between {{regular_non_availability_of_staff}}.start_time AND {{regular_non_availability_of_staff}}.end_time";
                $sqlQuery1 = "SELECT {{regular_non_availability_of_staff}}.non_availablility_id, `staff_id`, {{non_availability_of_staff}}.already_booked, `date`, {{regular_non_availability_of_staff}}.start_time, {{regular_non_availability_of_staff}}.end_time FROM {{regular_non_availability_of_staff}}, {{non_availability_of_staff}} WHERE {{regular_non_availability_of_staff}}.non_availablility_id = {{non_availability_of_staff}}.non_availablility_id AND {{non_availability_of_staff}}.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "' AND '" . $model->end_time . "'  between {{regular_non_availability_of_staff}}.start_time AND {{regular_non_availability_of_staff}}.end_time";
                $sqlQuery2 = "SELECT {{regular_non_availability_of_staff}}.non_availablility_id, `staff_id`, {{non_availability_of_staff}}.already_booked, `date`, {{regular_non_availability_of_staff}}.start_time, {{regular_non_availability_of_staff}}.end_time FROM {{regular_non_availability_of_staff}}, {{non_availability_of_staff}} WHERE {{regular_non_availability_of_staff}}.non_availablility_id = {{non_availability_of_staff}}.non_availablility_id AND {{non_availability_of_staff}}.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $model->start_date . "' AND  '" . $model->end_date . "' AND '" . $model->start_time . "' <= {{regular_non_availability_of_staff}}.start_time AND {{regular_non_availability_of_staff}}.start_time<='" . $model->end_time . "'";

                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
                $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();


                if (count($command) != 0) {
                    $allData = $command;
                } elseif (count($command1) != 0) {
                    $allData = $command1;
                } elseif (count($command2) != 0) {
                    $allData = $command2;
                }
            }
            if (count($allData) == 0) {
                if ($model->save()) {
                    Utility::applyNonAvailabilityMail();
                    $startDate = $model->start_date;
                    $endDate = $model->end_date;

                    $begin = new DateTime($startDate);
                    $end = new DateTime($endDate);

                    date_add($end, date_interval_create_from_date_string('1 days'));
                    date_format($end, 'Y-m-d');

                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

                    foreach ($daterange as $date) {
                        $nonRegularNonAvailability = new RegularNonAvailability;
                        $date->format("Y-m-d") . "<br>";
                        $nonRegularNonAvailability->non_availablility_id = $model->non_availablility_id . "<br>";
                        $nonRegularNonAvailability->date = $date->format("Y-m-d") . "<br>";
                        $nonRegularNonAvailability->start_time = $model->start_time . "<br>";
                        $nonRegularNonAvailability->end_time = $model->end_time . "<br>";
                        $nonRegularNonAvailability->save();
                    }

                    $this->redirect(array('view', 'id' => $model->non_availablility_id));
                } else {
                    if ($model->start_date != "") {
                        $model->start_date = Utility::changeDateToUK($model->start_date);
                    }
                    if ($model->end_date != "") {
                        $model->end_date = Utility::changeDateToUK($model->end_date);
                    }
                }
            } else {
                $i = 0;
                $j = 0;
                foreach ($allData as $dataAll) {
                    if ($dataAll['already_booked'] == "Y") {
                        $allBookingData[$i]['already_booked'] = $dataAll['already_booked'];
                        $allBookingData[$i]['start_time'] = $dataAll['start_time'];
                        $allBookingData[$i]['end_time'] = $dataAll['end_time'];
                        $allBookingData[$i]['date'] = $dataAll['date'];
                        $i++;
                    }
                    if ($dataAll['already_booked'] == "N") {
                        $allNotBookingData[$j]['already_booked'] = $dataAll['already_booked'];
                        $allNotBookingData[$j]['start_time'] = $dataAll['start_time'];
                        $allNotBookingData[$j]['end_time'] = $dataAll['end_time'];
                        $allNotBookingData[$j]['date'] = $dataAll['date'];
                        $allNotBookingData[$j]['non_availablility_id'] = $dataAll['non_availablility_id'];
                        $j++;
                    }
                }
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
            'chkData' => $allNotBookingData,
            'chkData1' => $allBookingData,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{non_availability_of_staff}} WHERE `non_availablility_id`=" . $id)->queryAll();
        if (count($command) != 0) {
            $chkModel = $this->loadModel($id);
            if ((!isset($chkModel)) || ($chkModel->staff_id != $_SESSION['logged_user']['id'])) {
                die('You are not authenticate for that action!');
            }
        } else {
            die('You are not authenticate for that action!');
        }

        $model = $this->loadModel($id);
        $allData = array();
        $allBookingData = array();
        $allNotBookingData = array();
        if ($model->start_date != "") {
            $model->start_date = Utility::changeDateToUK($model->start_date);
        }
        if ($model->end_date != "") {
            $model->end_date = Utility::changeDateToUK($model->end_date);
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['NonAvailability'])) {
            $model->attributes = $_POST['NonAvailability'];
            if ($model->start_date != "") {
                $model->start_date = Utility::changeDateToMysql($model->start_date);
            }
            if ($model->end_date != "") {
                $model->end_date = Utility::changeDateToMysql($model->end_date);
            }
            if ($model->start_date != "" && $model->end_date != "") {
                $sqlQuery = "SELECT {{regular_non_availability_of_staff}}.non_availablility_id, {{non_availability_of_staff}}.already_booked, `staff_id`, `date`, {{regular_non_availability_of_staff}}.start_time, {{regular_non_availability_of_staff}}.end_time FROM {{regular_non_availability_of_staff}}, {{non_availability_of_staff}} WHERE {{regular_non_availability_of_staff}}.non_availablility_id = {{non_availability_of_staff}}.non_availablility_id AND {{non_availability_of_staff}}.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "' AND '" . $model->start_time . "'  between {{regular_non_availability_of_staff}}.start_time AND {{regular_non_availability_of_staff}}.end_time AND {{regular_non_availability_of_staff}}.non_availablility_id != " . $model->non_availablility_id;
                $sqlQuery1 = "SELECT {{regular_non_availability_of_staff}}.non_availablility_id, {{non_availability_of_staff}}.already_booked, `staff_id`, `date`, {{regular_non_availability_of_staff}}.start_time, {{regular_non_availability_of_staff}}.end_time FROM {{regular_non_availability_of_staff}}, {{non_availability_of_staff}} WHERE {{regular_non_availability_of_staff}}.non_availablility_id = {{non_availability_of_staff}}.non_availablility_id AND {{non_availability_of_staff}}.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $model->start_date . "' AND '" . $model->end_date . "' AND '" . $model->end_time . "'  between {{regular_non_availability_of_staff}}.start_time AND {{regular_non_availability_of_staff}}.end_time AND {{regular_non_availability_of_staff}}.non_availablility_id != " . $model->non_availablility_id;
                $sqlQuery2 = "SELECT {{regular_non_availability_of_staff}}.non_availablility_id, {{non_availability_of_staff}}.already_booked, `staff_id`, `date`, {{regular_non_availability_of_staff}}.start_time, {{regular_non_availability_of_staff}}.end_time FROM {{regular_non_availability_of_staff}}, {{non_availability_of_staff}} WHERE {{regular_non_availability_of_staff}}.non_availablility_id = {{non_availability_of_staff}}.non_availablility_id AND {{non_availability_of_staff}}.staff_id = " . $_SESSION['logged_user']['id'] . " AND `date` BETWEEN '" . $model->start_date . "' AND  '" . $model->end_date . "' AND '" . $model->start_time . "' <= {{regular_non_availability_of_staff}}.start_time AND {{regular_non_availability_of_staff}}.start_time<='" . $model->end_time . "' AND {{regular_non_availability_of_staff}}.non_availablility_id != " . $model->non_availablility_id;

                $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
                $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
                $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();


                if (count($command) != 0) {
                    $allData = $command;
                } elseif (count($command1) != 0) {
                    $allData = $command1;
                } elseif (count($command2) != 0) {
                    $allData = $command2;
                }
            }
            if (count($allData) == 0) {
                if ($model->save()) {
                    Utility::applyNonAvailabilityMail();
                    $startDate = $model->start_date;
                    $endDate = $model->end_date;

                    $begin = new DateTime($startDate);
                    $end = new DateTime($endDate);

                    date_add($end, date_interval_create_from_date_string('1 days'));
                    date_format($end, 'Y-m-d');

                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                    $la_selectedDates = array();
                    $i = 0;
                    foreach ($daterange as $date) {
                        $nonRegularNonAvailability = new RegularNonAvailability;
                        $la_selectDates['dates'] = $date->format("Y-m-d");
                        $key = $i++;
                        $value = $la_selectDates['dates'];
                        $la_selectedDates[$key] = $value;

                        $nonRegularNonAvailability->non_availablility_id = $model->non_availablility_id;
                        $nonRegularNonAvailability->date = $date->format("Y-m-d");
                        $nonRegularNonAvailability->start_time = $model->start_time;
                        $nonRegularNonAvailability->end_time = $model->end_time;

                        $la_date_entry = Yii::app()->db->createCommand()
                                ->select('non_availablility_id, date, start_time, end_time')
                                ->from('ams_regular_non_availability_of_staff')
                                ->where('non_availablility_id=:non_availablility_id and date=:date', array(':non_availablility_id' => $nonRegularNonAvailability->non_availablility_id, ':date' => $nonRegularNonAvailability->date))
                                ->queryRow();
                        if (!$la_date_entry) {
                            $nonRegularNonAvailability->save();
                        } else {
                            if ($la_date_entry['start_time'] != $nonRegularNonAvailability->start_time) {
                                $data = array(
                                    "start_time" => $nonRegularNonAvailability->start_time
                                );
                                $update = Yii::app()->db->createCommand()
                                        ->update('ams_regular_non_availability_of_staff', $data, 'non_availablility_id=:non_availablility_id and date=:date', array(':non_availablility_id' => $nonRegularNonAvailability->non_availablility_id, ':date' => $nonRegularNonAvailability->date)
                                );
                            }

                            if ($la_date_entry['end_time'] != $nonRegularNonAvailability->end_time) {
                                $data = array(
                                    "end_time" => $nonRegularNonAvailability->end_time
                                );
                                $update = Yii::app()->db->createCommand()
                                        ->update('ams_regular_non_availability_of_staff', $data, 'non_availablility_id=:non_availablility_id and date=:date', array(':non_availablility_id' => $nonRegularNonAvailability->non_availablility_id, ':date' => $nonRegularNonAvailability->date)
                                );
                            }
                        }
                    }

                    $command = Yii::app()->db->createCommand("SELECT * FROM {{regular_non_availability_of_staff}} WHERE `non_availablility_id`=" . $nonRegularNonAvailability->non_availablility_id)->queryAll();
                    foreach ($command as $li_dDate) {
                        if (!in_array($li_dDate['date'], $la_selectedDates)) {
                            Yii::app()->db->createCommand()->delete('ams_regular_non_availability_of_staff', 'id =' . $li_dDate['id']);
                        }
                    }
                    $this->redirect(array('view', 'id' => $model->non_availablility_id));
                } else {
                    if ($model->start_date != "") {
                        $model->start_date = Utility::changeDateToUK($model->start_date);
                    }
                    if ($model->end_date != "") {
                        $model->end_date = Utility::changeDateToUK($model->end_date);
                    }
                }
            } else {
                $i = 0;
                $j = 0;
                foreach ($allData as $dataAll) {
                    if ($dataAll['already_booked'] == "Y") {
                        $allBookingData[$i]['already_booked'] = $dataAll['already_booked'];
                        $allBookingData[$i]['start_time'] = $dataAll['start_time'];
                        $allBookingData[$i]['end_time'] = $dataAll['end_time'];
                        $allBookingData[$i]['date'] = $dataAll['date'];
                        $i++;
                    }
                    if ($dataAll['already_booked'] == "N") {
                        $allNotBookingData[$j]['already_booked'] = $dataAll['already_booked'];
                        $allNotBookingData[$j]['start_time'] = $dataAll['start_time'];
                        $allNotBookingData[$j]['end_time'] = $dataAll['end_time'];
                        $allNotBookingData[$j]['date'] = $dataAll['date'];
                        $allNotBookingData[$j]['non_availablility_id'] = $dataAll['non_availablility_id'];
                        $j++;
                    }
                }
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
            'chkData' => $allNotBookingData,
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
        $command = Yii::app()->db->createCommand("SELECT * FROM {{regular_non_availability_of_staff}} WHERE `non_availablility_id`=" . $id)->queryAll();
        foreach ($command as $li_dDate) {
            Yii::app()->db->createCommand()->delete('ams_regular_non_availability_of_staff', 'id =' . $li_dDate['id']);
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('NonAvailability');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new NonAvailability('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NonAvailability']))
            $model->attributes = $_GET['NonAvailability'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return NonAvailability the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = NonAvailability::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param NonAvailability $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'non-availability-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

//    public function actionDateDelete() {
//        
//          $post = $_POST;
//          $id=$start_date=$end_date=$start_time=$end_time='';
//        $id = $post['id'];
//        $start_date = $post['start_date'];
//        $end_date = $post['end_date'];
//         $start_time = $post['start_time'];
//        $end_time = $post['end_time'];
//        
//        $ls_sql = 'DELETE FROM {{regular_non_availability_of_staff}} WHERE id='.$id; 
//        Yii::app()->db->createCommand($ls_sql)->Execute();
//        
//        
//            $sqlQuery = "SELECT * FROM `ams_regular_non_availability_of_staff` WHERE `date` BETWEEN '".$start_date."' AND '".$end_date."' AND '".$start_time."'  between `start_time` AND `end_time`";
//            $sqlQuery1 = "SELECT * FROM `ams_regular_non_availability_of_staff` WHERE `date` BETWEEN '".$start_date."' AND '".$end_date."' AND '".$end_time."'  between `start_time` AND `end_time`";
//            $sqlQuery2 = "SELECT * FROM `ams_regular_non_availability_of_staff` WHERE `date` BETWEEN '".$start_date."' AND  '".$end_date."' AND '".$start_time."' <= `start_time` AND `end_time`<='".$end_time."'";
//
//            $command = Yii::app()->db->createCommand($sqlQuery)->queryAll();
//            $command1 = Yii::app()->db->createCommand($sqlQuery1)->queryAll();
//            $command2 = Yii::app()->db->createCommand($sqlQuery2)->queryAll();
//            
//            
//            if(count($command)!=0){
//                $allData = $command;
//            } elseif(count($command1)!=0) {
//                $allData = $command1;
//            } elseif(count($command2)!=0) {
//                $allData = $command2;
//            }
//            
//            $this->renderPartial('ajax_existing_entry', array(
//            'chkData' => $allData,
//        ));
//    }
}
