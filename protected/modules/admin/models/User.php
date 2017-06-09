<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $address
 * @property string $type
 * @property string $staff_id
 * @property string $image
 * @property string $active_status
 */
class User extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_name, last_name, gender, date_of_birth, email, password, type, mobile', 'required', 'on' => 'exceptDraftArchieve'),
            array('first_name, last_name, email', 'length', 'max' => 100),
            array('gender', 'length', 'max' => 6),
            array('email', 'unique'),
            array('password, address, activation_key', 'length', 'max' => 350),
            array('mobile', 'length', 'max' => 30),
            array('type, active_status', 'length', 'max' => 1),
            array('staff_id', 'length', 'max' => 10),
            array('mobile', 'validateMobileNumber'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_name, last_name, gender, email, date_of_birth, password, mobile, address, type, staff_id, image, active_status, activation_key', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'enquiries' => array(self::HAS_MANY, 'ShiftEnquiryAck', 'agent_user_id'),
            'shiftEnquiry' => array(self::HAS_MANY, 'ShiftEnquiry', 'staff_id'),
            'staffs' => array(self::HAS_MANY, 'NonAvailability', 'id'),
//            'shiftManagementForHospitals' => array(self::HAS_MANY, 'ShiftManagementForHospital', 'request_accepted_by'),
            'staff' => array(self::BELONGS_TO, 'StaffRegistration', 'staff_id'),
            'userActivities' => array(self::HAS_MANY, 'UserActivity', 'user_id'),
            'staffBooking' => array(self::HAS_MANY, 'StaffBooking', 'id'),
            'users' => array(self::HAS_MANY, 'ShiftManagementForHospital', 'id'),
            'staffJobTypeRate' => array(self::HAS_MANY, 'StaffJobTypeRate', 'id'),
            'timesheet' => array(self::HAS_MANY, 'Timesheet', 'id'),
            'timesheetPaymentDetailsForStaff' => array(self::HAS_MANY, 'TimesheetPaymentDetailsForStaff', 'id'),
            'trainingDetail' => array(self::HAS_MANY, 'TrainingDetails', 'id'),
            'uploadedTimesheetByStaff' => array(self::HAS_MANY, 'UploadedTimesheetByStaff', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'email' => 'Email',
            'date_of_birth' => 'Date of Birth',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'type' => 'Type',
            'staff_id' => 'Staff',
            'image' => 'Image',
            'active_status' => 'Active Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('active_status', $this->active_status, true);

        $criteria->addInCondition('t.type', array('A', 'C', 'D', 'M', 'F'));


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function validateMobileNumber($attribute, $params) {
        $ls_error = Utility::validateMobileNumber($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function selectedUsers($li_staffId) {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `type` = 'S' AND `staff_id` = '" . $li_staffId . "'")->queryAll();
        $la_user = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['staff_id'];
            $value = $lo_user['image'];
            $la_user[$key] = $value;
        }
        return $la_user;
    }

    public function allUsers() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `type` != 'S' AND `active_status`='Y'")->queryAll();
        $la_user = array('' => "Select One");
        foreach ($command as $lo_user) {
            $key = $lo_user['id'];
            $value = $lo_user['first_name'];
            $la_user[$key] = $value;
        }
        return $la_user;
    }
    public function staffAll() {
        $command = Yii::app()->db->createCommand("SELECT U.*,CONCAT(`first_name`,' ', `last_name`) as `full_name` FROM {{user}} U WHERE U.type = 'S' AND U.active_status='Y' ORDER BY U.first_name")->queryAll();
        $la_staff = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['id'];
            $la_staff[$key] = $lo_user['full_name'] . ' (' . $lo_user['email'] . ')';
        }
        return $la_staff;
    }
    public function allCoordinator() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `type` = 'C' AND `active_status`='Y'")->queryAll();
        $la_user = array('' => "Select One");
        foreach ($command as $lo_user) {
            $key = $lo_user['id'];
            $value = $lo_user['email'];
            $la_user[$key] = $value;
        }
        return $la_user;
    }

    public function getStaffName($id) {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `id` = " . $id . "")->queryRow();
        $value = $command['first_name'] . " " . $command['last_name'] . " (" . $command['email'] . ")";

        return $value;
    }

}
