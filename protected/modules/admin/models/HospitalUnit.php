<?php

/**
 * This is the model class for table "{{hospital_unit}}".
 *
 * The followings are the available columns in table '{{hospital_unit}}':
 * @property string $hospital_unit_id
 * @property string $hospital_id
 * @property string $hospital_unit
 * @property string $address
 * @property string $local_area_id
 * @property string $email
 * @property string $contact_number
 * @property string $hospital_unit_active_status
 *
 * The followings are the available model relations:
 * @property WardHospitalUnitMap[] $wardHospitalUnitMaps
 */
class HospitalUnit extends CActiveRecord {

    public $hospital_name;
    public $area_name;
    public $wards;
    public $email;
    public $course_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{hospital_unit}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hospital_id, hospital_unit, address, local_area_id, hospital_email, contact_number, training_needed, relevant_coordinator_id', 'required', 'message' => 'Please enter {attribute}.'),
            array('hospital_id, contact_number, relevant_coordinator_id', 'length', 'min' => 0),
            array('hospital_unit', 'length', 'max' => 255),
            array('local_area_id', 'length', 'max' => 5),
            array('hospital_email', 'length', 'max' => 150),
            array('hospital_unit_active_status', 'length', 'max' => 1),
            array('hospital_name, area_name, training_needed, course_name', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('hospital_unit', 'unitVerification'),
            array('hospital_email', 'emailVerification'),
            array('contact_number', 'contactVerification'),
            array('wards', 'wardVerification'),
            array('hospital_unit_id, hospital_id, wards, hospital_unit, address, local_area_id, hospital_email, contact_number, training_needed, relevant_coordinator_id, hospital_unit_active_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'localArea' => array(self::BELONGS_TO, 'WorkArea', 'local_area_id'),
            'hospital' => array(self::BELONGS_TO, 'HospitalRegistration', 'hospital_id'),
            'hospitals' => array(self::BELONGS_TO, 'User', 'relevant_coordinator_id'),
            'serviceCompleteds' => array(self::HAS_MANY, 'ServiceCompleted', 'hospital_unit_id'),
            'shiftManagementForHospitals' => array(self::HAS_MANY, 'ShiftManagementForHospital', 'hospital_unit_id'),
            'availableShiftForHospital' => array(self::HAS_MANY, 'AvailableShiftForHospital', 'hospital_unit_id'),
            'allTraining' => array(self::BELONGS_TO, 'AllTraining', 'training_needed'),
            'hospitalJobTypeRate' => array(self::HAS_MANY, 'HospitalJobTypeRate', 'hospital_unit_id'),
            'timesheet' => array(self::HAS_MANY, 'Timesheet', 'hospital_unit_id'),
//            'uploadedTimesheetByStaff' => array(self::HAS_MANY, 'UploadedTimesheetByStaff', 'hospital_unit_id'),
            'timesheetPaymentDetailsForHospital' => array(self::HAS_MANY, 'TimesheetPaymentDetailsForHospital', 'hospital_unit_id'),
        );
    }

    /*
     * @Wards varification.
     */

    public function wardVerification($attribute, $params) {
        $wards_name = $_POST['HospitalUnit']['wards'];
        $count = count($wards_name);
        if ($count == 0) {
            $this->addError($attribute, 'Please select ward!');
        }
    }

    /*
     * @Hospital unit validation.
     */

    public function unitVerification($attribute, $params) {
        $hospitalUnitName = $this->$attribute;
        $countName = strlen($hospitalUnitName);
        $pattern = '/^([A-Z])+(([a-zA-Z0-9\s])+)+$/';
        if ($countName < 2) {
            $this->addError($attribute, 'Please enter valid unit name!');
        } else if (!preg_match($pattern, $hospitalUnitName)) {
            $this->addError($attribute, 'First character of a hospital should be capital!');
        }
    }

    /*
     * @Email varification.
     */

    public function emailVerification($attribute, $params) {
        $email = $this->$attribute;
        $countEmail = strlen($email);
        $regex = '/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z]{2,4})+$/';
        if (!preg_match($regex, $email)) {
            $this->addError($attribute, 'Please enter valid email!');
        }
    }

    /*
     * @Contact number varification.
     */

    public function contactVerification($attribute, $params) {
        $contactNumber = $this->$attribute;
        $countContactNumber = strlen($contactNumber);
        if (!preg_match('/^[1-9][0-9]{0,15}$/', $contactNumber)) {
            $this->addError($attribute, 'Please enter valid contact number!');
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'hospital_unit_id' => 'Hospital',
            'hospital_id' => 'Hospital Group',
            'hospital_unit' => 'Hospital Name',
            'address' => 'Address',
            'local_area_id' => 'Local Area',
            'hospital_email' => 'Hospital Email',
            'contact_number' => 'Contact Number',
            'relevant_coordinator_id' => 'Relevant Coordinator',
            'training_needed' => 'Training Needed',
            'course_name' => 'Training Needed',
            'email' => 'Relevant Coordinator',
            'hospital_unit_active_status' => 'Active Status',
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
        $criteria->with = array('hospital', 'hospitals', 'localArea', 'allTraining');
        $criteria->compare('hospital.hospital_name', $this->hospital_name, true);
        $criteria->compare('hospitals.email', $this->email, true);
        $criteria->compare('localArea.area_name', $this->area_name, true);
        $criteria->compare('allTraining.course_name', $this->course_name, true);

        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('hospital.hospital_name', $this->hospital_id, true);
        $criteria->compare('hospital.hospital_name', $this->hospital_id, true);
        $criteria->compare('hospital_unit', $this->hospital_unit, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('local_area_id', $this->local_area_id, true);
        $criteria->compare('t.hospital_email', $this->hospital_email, true);
        $criteria->compare('contact_number', $this->contact_number, true);
        $criteria->compare('relevant_coordinator_id', $this->relevant_coordinator_id, true);
        $criteria->compare('t.hospital_unit_active_status', $this->hospital_unit_active_status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "hospital_unit_id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HospitalUnit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function allHospitalUnits() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{hospital_unit}} WHERE `hospital_unit_active_status`='Y' ORDER BY hospital_unit")->queryAll();
        $la_hos = array('' => "Select hospital unit");
        foreach ($command as $lo_user) {
            $key = $lo_user['hospital_unit_id'];
            $value = $lo_user['hospital_unit'];
            $la_hos[$key] = $value;
        }
        return $la_hos;
    }

    public function allHospital() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{hospital_unit}} WHERE `hospital_unit_active_status`='Y' ORDER BY hospital_unit")->queryAll();
        $la_hos = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['hospital_unit_id'];
            $value = $lo_user['hospital_unit'];
            $la_hos[$key] = $value;
        }
        return $la_hos;
    }

    public function getHospitalName($id) {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{hospital_unit}} WHERE `hospital_unit_id` = " . $id . "")->queryRow();
        $value = $command['hospital_unit'];

        return $value;
    }

}
