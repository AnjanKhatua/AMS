<?php

/**
 * This is the model class for table "{{shift_management_for_hospital}}".
 *
 * The followings are the available columns in table '{{shift_management_for_hospital}}':
 * @property string $staff_request_id
 * @property string $hospital_unit_id
 * @property string $ward_id
 * @property string $job_type_id
 * @property string $quantity
 * @property string $quantity_confirmed
 * @property string $shift_start_datetime
 * @property string $shift_end_datetime
 * @property string $requested_date
 * @property string $requested_time
 * @property string $requested_person
 * @property string $request_accepted_by
 * @property string $requested_person_mobile_number
 * @property string $status
 */
class AvailableShiftForHospital extends CActiveRecord {

   public $ward_name;
   public $job_type;
   public $hospital_unit;
   public $isApplied = 1;
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
            array('hospital_unit_id, ward_id, job_type_id, quantity, quantity_confirmed, shift_start_datetime, shift_end_datetime, requested_date, requested_time, requested_person, request_accepted_by, requested_person_mobile_number', 'required'),
            array('hospital_unit_id, ward_id, job_type_id, request_accepted_by', 'length', 'max' => 10),
            array('quantity, quantity_confirmed', 'length', 'max' => 3),
            array('requested_person', 'length', 'max' => 150),
            array('requested_person_mobile_number', 'length', 'max' => 15),
            array('status', 'length', 'max' => 1),
            array('ward_name, job_type, hospital_unit', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('staff_request_id, hospital_unit_id, job_type, ward_id, job_type_id, quantity, quantity_confirmed, shift_start_datetime, shift_end_datetime, requested_date, requested_time, requested_person, request_accepted_by, requested_person_mobile_number, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'jobType' => array(self::BELONGS_TO, 'JobType', 'job_type_id'),
            'hospitalUnit' => array(self::BELONGS_TO, 'HospitalUnit', 'hospital_unit_id'),
            'staffBooking' => array(self::HAS_MANY, 'StaffBooking', 'staff_request_id'),
            'ward' => array(self::BELONGS_TO, 'Ward', 'ward_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'staff_request_id' => 'Requested Id',
            'hospital_unit_id' => 'Hospital Unit',
            'ward_id' => 'Ward',
            'job_type_id' => 'Job Type',
            'quantity' => 'Quantity',
            'quantity_confirmed' => 'Quantity Confirmed',
            'shift_start_datetime' => 'Shift Start Datetime',
            'shift_end_datetime' => 'Shift End Datetime',
            'requested_date' => 'Requested Date',
            'requested_time' => 'Requested Time',
            'requested_person' => 'Requested Person',
            'request_accepted_by' => 'Request Accepted By',
            'requested_person_mobile_number' => 'Requested Person Mobile Number',
            'status' => 'Status',
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

        $criteria->with = array('ward', 'jobType', 'hospitalUnit');
        $criteria->compare('ward.ward_name', $this->ward_name, true);
        $criteria->compare('jobType.job_type', $this->job_type, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);

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

        $criteria->addInCondition('t.job_type_id',  Utility::getAvailableJobTypeForStaff($_SESSION['logged_user']['staff_id']));
        $criteria->addInCondition('t.staff_request_id',  Utility::getAvailableDateTimeForStaff($_SESSION['logged_user']['id']));

        

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
     * @return AvailableShiftForHospital the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
