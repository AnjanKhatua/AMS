<?php

/**
 * This is the model class for table "{{shift_management_for_hospital}}".
 *
 * The followings are the available columns in table '{{shift_management_for_hospital}}':
 * @property string $staff_request_id
 * @property string $hospital_unit_id
 * @property string $job_type_id
 * @property string $quantity
 * @property string $date
 * @property string $shift_start_time
 * @property string $shift_end_time
 * @property string $requested_date
 * @property string $requested_time
 * @property string $requested_person
 * @property string $request_accepted_by
 * @property string $requested_person_mobile_number
 *
 * The followings are the available model relations:
 * @property Booking[] $bookings
 * @property Enquiry[] $enquiries
 * @property HospitalUnit $hospitalUnit
 * @property JobType $jobType
 * @property User $requestAcceptedBy
 * @property StaffRequestRequiredTrainingMapTable[] $staffRequestRequiredTrainingMapTables
 */
class ShiftManagementForHospital extends CActiveRecord {

    public $hospital_unit;
    public $job_type;
    public $user;
    public $email;
    public $ward_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{shift_management_for_hospital}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hospital_unit_id,  shift_start_datetime, shift_end_datetime, requested_date, requested_time, requested_person, request_accepted_by, requested_person_mobile_number', 'required', 'message' => 'Please enter {attribute}.'),
            array('hospital_unit_id, job_type_id, request_accepted_by', 'length', 'max' => 10),
            array('quantity', 'length', 'max' => 3),
            array('requested_person', 'length', 'max' => 150),
            array('email', 'length', 'min' => 0),
            array('ward_name, job_type, user, hospital_unit', 'length', 'min' => 0),
            array('quantity', 'match', 'pattern' => '/^[1-9][0-9]*$/u', 'message' => 'Please input valid quantity'),
            array('requested_person', 'match', 'pattern' => '/^[A-Za-z ]+$/u', 'message' => 'Please input valid name'),
            //array('requested_date','validateRequestedDate'),
            //array('requested_time','validateRequestedTime'),
            array('requested_person_mobile_number', 'match', 'pattern' => '/^[0-9 \+]+$/u', 'message' => 'Please input valid mobile number'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('staff_request_id, hospital_unit_id, job_type_id, email, quantity, quantity_confirmed, notes, date, shift_start_time, shift_end_time, requested_date, requested_time, requested_person, request_accepted_by, requested_person_mobile_number, status', 'safe', 'on' => 'search'),
        );
    }

    /*
     * @Requested time validation.
     */

    public function validateRequestedTime($attribute, $params) {
        $tm = $this->$attribute;

        if ($tm == '0:0') {
            $this->addError($attribute, 'Please enter valid time!');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bookings' => array(self::HAS_MANY, 'Booking', 'staff_request_id'),
            'enquiries' => array(self::HAS_MANY, 'ShiftEnquiryAck', 'staff_request_id'),
            'enquirie' => array(self::HAS_MANY, 'ShiftEnquiry', 'staff_request_id'),
            'hospitalUnit' => array(self::BELONGS_TO, 'HospitalUnit', 'hospital_unit_id'),
            'ward' => array(self::BELONGS_TO, 'Ward', 'ward_id'),
            'jobType' => array(self::BELONGS_TO, 'JobType', 'job_type_id'),
            'requestAcceptedBy' => array(self::BELONGS_TO, 'User', 'request_accepted_by'),
            'staffRequestRequiredTrainingMapTables' => array(self::HAS_MANY, 'StaffRequestRequiredTrainingMapTable', 'request_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'staff_request_id' => 'Request Id',
            'hospital_unit_id' => 'Hospital Unit',
            'job_type_id' => 'Job Type',
            'quantity' => 'Quantity',
            'quantity_confirmed' => 'Quantity Confirmed',
            'notes' => 'Notes',
            'date' => 'Date',
            'shift_start_datetime' => 'Shift Start Date Time',
            'shift_end_datetime' => 'Shift End Date Time',
            'requested_time' => 'Requested Time',
            'requested_person' => 'Requested By',
            'email' => 'Request Accepted By',
            'requested_person_mobile_number' => 'Requested Person Mobile Number',
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

        $criteria->with = array('ward', 'jobType', 'hospitalUnit', 'requestAcceptedBy');
        $criteria->compare('ward.ward_name', $this->ward_name, true);
        $criteria->compare('jobType.job_type', $this->job_type, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);
        $criteria->compare('requestAcceptedBy.email', $this->email, true);

        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('quantity_confirmed', $this->quantity_confirmed, true);
        $criteria->compare('DATE_FORMAT(shift_start_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(shift_end_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_end_datetime, true);
        $criteria->compare('DATE_FORMAT(requested_date,"%d-%m-%Y")', $this->requested_date, true);
        $criteria->compare('requested_time', $this->requested_time, true);
        $criteria->compare('requested_person', $this->requested_person, true);
        $criteria->compare('request_accepted_by', $this->request_accepted_by, true);
        $criteria->compare('requested_person_mobile_number', $this->requested_person_mobile_number, true);
        $criteria->compare('status', $this->status, true);

        $criteria->addInCondition('t.staff_request_id', Utility::getActiveShifts());

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'staff_request_id DESC',
            )
        ));
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
    public function search_archive() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('ward', 'jobType', 'hospitalUnit', 'requestAcceptedBy');
        $criteria->compare('ward.ward_name', $this->ward_name, true);
        $criteria->compare('jobType.job_type', $this->job_type, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);
        $criteria->compare('requestAcceptedBy.email', $this->email, true);

        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('quantity_confirmed', $this->quantity_confirmed, true);
        $criteria->compare('DATE_FORMAT(shift_start_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(shift_end_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_end_datetime, true);
        $criteria->compare('DATE_FORMAT(requested_date,"%d-%m-%Y")', $this->requested_date, true);
        $criteria->compare('requested_time', $this->requested_time, true);
        $criteria->compare('requested_person', $this->requested_person, true);
        $criteria->compare('request_accepted_by', $this->request_accepted_by, true);
        $criteria->compare('requested_person_mobile_number', $this->requested_person_mobile_number, true);
        $criteria->compare('status', $this->status, true);

        $criteria->addInCondition('t.staff_request_id', Utility::getArchiveShifts());

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'staff_request_id DESC',
            )
        ));
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
    public function search_self() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('ward', 'jobType', 'hospitalUnit', 'requestAcceptedBy');
        $criteria->compare('ward.ward_name', $this->ward_name, true);
        $criteria->compare('jobType.job_type', $this->job_type, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);
        $criteria->compare('requestAcceptedBy.email', $this->email, true);

        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('quantity_confirmed', $this->quantity_confirmed, true);
        $criteria->compare('DATE_FORMAT(shift_start_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(shift_end_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_end_datetime, true);
        $criteria->compare('DATE_FORMAT(requested_date,"%d-%m-%Y")', $this->requested_date, true);
        $criteria->compare('requested_time', $this->requested_time, true);
        $criteria->compare('requested_person', $this->requested_person, true);
        $criteria->compare('request_accepted_by', $_SESSION['logged_user']['id'], true);
        $criteria->compare('requested_person_mobile_number', $this->requested_person_mobile_number, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'staff_request_id DESC',
            )
        ));
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
    public function search_unfilled() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('ward', 'jobType', 'hospitalUnit', 'requestAcceptedBy');
        $criteria->compare('ward.ward_name', $this->ward_name, true);
        $criteria->compare('jobType.job_type', $this->job_type, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);
        $criteria->compare('requestAcceptedBy.email', $this->email, true);

        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('quantity_confirmed', $this->quantity_confirmed, true);
        $criteria->compare('DATE_FORMAT(shift_start_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(shift_end_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_end_datetime, true);
        $criteria->compare('DATE_FORMAT(requested_date,"%d-%m-%Y")', $this->requested_date, true);
        $criteria->compare('requested_time', $this->requested_time, true);
        $criteria->compare('requested_person', $this->requested_person, true);
        $criteria->compare('request_accepted_by', $this->request_accepted_by, true);
        $criteria->compare('requested_person_mobile_number', $this->requested_person_mobile_number, true);
        $criteria->compare('status', $this->status, true);

        $criteria->addInCondition('t.staff_request_id', Utility::getUnfilledShifts());

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'staff_request_id DESC',
            )
        ));
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
    public function search_historical_filled() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('ward', 'jobType', 'hospitalUnit', 'requestAcceptedBy');
        $criteria->compare('ward.ward_name', $this->ward_name, true);
        $criteria->compare('jobType.job_type', $this->job_type, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);
        $criteria->compare('requestAcceptedBy.email', $this->email, true);

        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('quantity_confirmed', $this->quantity_confirmed, true);
        $criteria->compare('DATE_FORMAT(shift_start_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(shift_end_datetime,"%d-%m-%Y %H:%i:%s")', $this->shift_end_datetime, true);
        $criteria->compare('DATE_FORMAT(requested_date,"%d-%m-%Y")', $this->requested_date, true);
        $criteria->compare('requested_time', $this->requested_time, true);
        $criteria->compare('requested_person', $this->requested_person, true);
        $criteria->compare('request_accepted_by', $this->request_accepted_by, true);
        $criteria->compare('requested_person_mobile_number', $this->requested_person_mobile_number, true);
        $criteria->compare('status', $this->status, true);

        $criteria->addInCondition('t.staff_request_id', Utility::getHistoricalFilledShifts());

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'staff_request_id DESC',
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ShiftManagementForHospital the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
