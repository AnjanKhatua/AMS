<?php

class DefaultController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionSettings() {
//        if(!isset($_POST['oldContact']) && isset($_SESSION['error'])){
//            $_SESSION['error'] = "";
//        }
        $this->render('settings');
    }

    public function actionProfileUpdate() {
//        print_r($_POST);die;
        $status = array();
        if (isset($_POST['newContact'])) {
            if ($_POST['oldContact'] != '' && $_POST['newContact'] != '') {
                $command = Yii::app()->db->createCommand("SELECT `mobile_no` FROM {{staff_registration}} WHERE `staff_id`='" . $_SESSION['logged_user']['staff_id'] . "'")->queryRow();
                if ($command['mobile_no'] == $_POST['oldContact']) {
                    $data = array(
                        "mobile_no" => $_POST['newContact']
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_staff_registration', $data, 'staff_id=:staff_id', array(':staff_id' => $_SESSION['logged_user']['staff_id'])
                    );
                    $data = array(
                        "mobile" => $_POST['newContact']
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_user', $data, 'staff_id=:staff_id', array(':staff_id' => $_SESSION['logged_user']['staff_id'])
                    );
                    $data = array(
                        "mobile_no" => $_POST['newContact']
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_staff_registration', $data, 'staff_id=:staff_id', array(':staff_id' => $_SESSION['logged_user']['staff_id'])
                    );
                    $_SESSION['logged_user']['mobile'] = $_POST['newContact'];
                    Utility::changeContactNumberMail();
                } else {
                    $status['errorNumber'] = 'set';
                }
            }
        } elseif (isset($_POST['newPassword'])) {
            if ($_POST['oldPassword'] != '' && $_POST['newPassword'] != '') {
                $command = Yii::app()->db->createCommand("SELECT `password` FROM {{user}} WHERE `staff_id`='" . $_SESSION['logged_user']['staff_id'] . "'")->queryRow();
                if ($command['password'] == md5($_POST['oldPassword'])) {
                    $data = array(
                        "password" => md5($_POST['newPassword'])
                    );
                    $update = Yii::app()->db->createCommand()
                            ->update('ams_user', $data, 'staff_id=:staff_id', array(':staff_id' => $_SESSION['logged_user']['staff_id'])
                    );
                } else {
                    $status['errorPassword'] = 'set';
                }
            }
        } elseif (isset($_POST['docType'])) {
            $length = count($_POST['docType']);

            for ($i = 0; $i < $length; $i++) {
                $staffDoc = new StaffDocument;
                $staffDoc->staff_id = $_SESSION['logged_user']['staff_id'];
                $staffDoc->document_header_id = $_POST['docType'][$i];
                $staffDoc->document_name = $_FILES['fileName']['name'][$i];

                $oldimage = "";
                $command = Yii::app()->db->createCommand("SELECT document_name FROM {{staff_document}} WHERE `document_header_id` = " . $staffDoc->document_header_id . " and  `staff_id` = " . $_SESSION['logged_user']['staff_id'])->queryAll();
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
                                ->update('ams_staff_document', $data, 'staff_id=:staff_id and document_header_id=:document_header_id', array(':staff_id' => $_SESSION['logged_user']['staff_id'], ':document_header_id' => $staffDoc->document_header_id)
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
        $this->render('settings', array(
            'model' => $status,
        ));
    }

    public function actionProfilePicture() {
//        print_r($_SESSION['logged_user']);
//        print_r($_FILES);
//        die;
        $model = new User;

        $oldimage = $_SESSION['logged_user']['image'];
        if ($_FILES['image']['name'] != "") {
            if ($oldimage != "1666-male.jpg" && $_SESSION['logged_user']['gender'] == "Male") {
                @unlink(Yii::app()->basePath . '/../userImage/' . $oldimage);
            }

            if ($_SESSION['logged_user']['gender'] == "Female" && $oldimage != "2043-female.png") {
                @unlink(Yii::app()->basePath . '/../userImage/' . $oldimage);
            }

            $rnd = time();
            $fileNameImage = $rnd . "-" . $_FILES['image']['name']; // random number + file name
            $model->image = $fileNameImage;

            if ($model->image != "") {
                $data = array(
                    "image" => $model->image
                );
                $update = Yii::app()->db->createCommand()
                        ->update('ams_user', $data, 'staff_id=:staff_id and id=:id', array(':staff_id' => $_SESSION['logged_user']['staff_id'], ':id' => $_SESSION['logged_user']['id'])
                );
                $destdir = Yii::app()->basePath . '/../userImage/';
                move_uploaded_file($_FILES['image']['tmp_name'], $destdir . $fileNameImage);
                $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `active_status`='Y'  AND `email`='" . $_SESSION['logged_user']['email'] . "' AND `password`='" . $_SESSION['logged_user']['password'] . "' ")->queryRow();
                $_SESSION['logged_user'] = $command;
            }
        }
        $ls_staffUpdatePageUrl = YII::app()->createUrl('staff/default/index');
        header('Location:' . $ls_staffUpdatePageUrl);
        exit();
    }

}
