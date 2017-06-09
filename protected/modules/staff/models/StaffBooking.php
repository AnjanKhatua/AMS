<?php

/**
 * This is the model class for table "{{booking}}".
 *
 * The followings are the available columns in table '{{booking}}':
 * @property string $booking_id
 * @property string $staff_request_id
 * @property string $staff_id
 * @property string $confirmation_date
 * @property string $confirmation_time
 * @property string $confirm_by_whom
 * @property string $cancellation_date
 * @property string $cancellation_time
 * @property string $cancel_by_whom
 * @property string $cancel_requested_by
 *
 * The followings are the available model relations:
 * @property StaffRegistration $staff
 * @property ShiftManagementForHospital $staffRequest
 * @property ServiceCompleted[] $serviceCompleteds
 */
class StaffBooking extends CActiveRecord {

    public $first_name;
    public $ward_id;
    public $job_type_id;
    public $hospital_unit_id;
    public $shift_start_datetime;
    public $shift_end_datetime;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{booking}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('staff_request_id, staff_id, confirmation_date, confirmation_time, confirm_by_whom, cancellation_date, cancellation_time, cancel_by_whom', 'required'),
            array('staff_request_id, staff_id, cancel_by_whom', 'length', 'max' => 10),
            array('confirm_by_whom', 'length', 'max' => 150),
            array('ward_id, job_type_id, hospital_unit_id, first_name, shift_start_datetime, shift_end_datetime', 'length', 'min' => 0),
            array('cancel_requested_by', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('booking_id, staff_request_id, staff_id, confirmation_date, confirmation_time, confirm_by_whom, cancellation_date, cancellation_time, cancel_by_whom, cancel_requested_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'staff' => array(self::BELONGS_TO, 'StaffRegistration', 'staff_id'),
            'staffRequest' => array(self::BELONGS_TO, 'ShiftManagementForHospital', 'staff_request_id'),
            'serviceCompleteds' => array(self::HAS_MANY, 'ServiceCompleted', 'booking_id'),
            'user' => array(self::BELONGS_TO, 'User', 'staff_id'),
//                        'jobType' => array(self::BELONGS_TO, 'JobType', 'job_type_id'),
//                        'hospitalUnit' => array(self::BELONGS_TO, 'HospitalUnit', 'hospital_unit_id'),
//                        'ward' => array(self::BELONGS_TO, 'Ward', 'ward_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'booking_id' => 'Booking',
            'staff_request_id' => 'Staff Request',
            'staff_id' => 'Staff Name',
            'ward_id' => 'Ward',
            'job_type_id' => 'Job Type',
            'hospital_unit_id' => 'Hospital Unit',
            'first_name' => 'Staff Name',
            'shift_start_datetime' => 'Shift Start Datetime',
            'shift_end_datetime' => 'Shift End Datetime',
            'confirmation_date' => 'Confirmation Date',
            'confirmation_time' => 'Confirmation Time',
            'confirm_by_whom' => 'Confirm By Whom',
            'cancellation_date' => 'Cancellation Date',
            'cancellation_time' => 'Cancellation Time',
            'cancel_by_whom' => 'Cancel By Whom',
            'cancel_requested_by' => 'Cancel Requested By',
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
        $criteria->with = array('staffRequest', 'staff', 'staffRequest.ward', 'staffRequest.jobType', 'staffRequest.hospitalUnit');
        $criteria->compare('staff.first_name', $this->first_name, true);
        $criteria->compare('ward.ward_name', $this->ward_id, true);
        $criteria->compare('jobType.job_type', $this->job_type_id, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit_id, true);
        $criteria->compare('DATE_FORMAT(staffRequest.shift_start_datetime,"%d-%m-%Y")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(staffRequest.shift_end_datetime,"%d-%m-%Y")', $this->shift_end_datetime, true);

        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('booking_id', $this->booking_id, true);
        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('confirmation_date', $this->confirmation_date, true);
        $criteria->compare('confirmation_time', $this->confirmation_time, true);
        $criteria->compare('confirm_by_whom', $this->confirm_by_whom, true);
        $criteria->compare('cancellation_date', $this->cancellation_date, true);
        $criteria->compare('cancellation_time', $this->cancellation_time, true);
        $criteria->compare('cancel_by_whom', $this->cancel_by_whom, true);
        $criteria->compare('cancel_requested_by', $this->cancel_requested_by, true);

        $criteria->addInCondition('t.booking_id', Utility::getUpcomingBookingForStaff($_SESSION['logged_user']['id']));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
    public function search_previous() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('staffRequest', 'staff', 'staffRequest.ward', 'staffRequest.jobType', 'staffRequest.hospitalUnit');
        $criteria->compare('staff.first_name', $this->first_name, true);
        $criteria->compare('ward.ward_name', $this->ward_id, true);
        $criteria->compare('jobType.job_type', $this->job_type_id, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit_id, true);
        $criteria->compare('DATE_FORMAT(staffRequest.shift_start_datetime,"%d-%m-%Y")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(staffRequest.shift_end_datetime,"%d-%m-%Y")', $this->shift_end_datetime, true);

        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('booking_id', $this->booking_id, true);
        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('confirmation_date', $this->confirmation_date, true);
        $criteria->compare('confirmation_time', $this->confirmation_time, true);
        $criteria->compare('confirm_by_whom', $this->confirm_by_whom, true);
        $criteria->compare('cancellation_date', $this->cancellation_date, true);
        $criteria->compare('cancellation_time', $this->cancellation_time, true);
        $criteria->compare('cancel_by_whom', $this->cancel_by_whom, true);
        $criteria->compare('cancel_requested_by', $this->cancel_requested_by, true);

        $criteria->addInCondition('t.booking_id', Utility::getPreviousBookingForStaff($_SESSION['logged_user']['id']));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
    public function search_cancel() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('staffRequest', 'staff', 'staffRequest.ward', 'staffRequest.jobType', 'staffRequest.hospitalUnit');
        $criteria->compare('staff.first_name', $this->first_name, true);
        $criteria->compare('ward.ward_name', $this->ward_id, true);
        $criteria->compare('jobType.job_type', $this->job_type_id, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit_id, true);
        $criteria->compare('DATE_FORMAT(staffRequest.shift_start_datetime,"%d-%m-%Y")', $this->shift_start_datetime, true);
        $criteria->compare('DATE_FORMAT(staffRequest.shift_end_datetime,"%d-%m-%Y")', $this->shift_end_datetime, true);

        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('booking_id', $this->booking_id, true);
        $criteria->compare('staff_request_id', $this->staff_request_id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('confirmation_date', $this->confirmation_date, true);
        $criteria->compare('confirmation_time', $this->confirmation_time, true);
        $criteria->compare('confirm_by_whom', $this->confirm_by_whom, true);
        $criteria->compare('cancellation_date', $this->cancellation_date, true);
        $criteria->compare('cancellation_time', $this->cancellation_time, true);
        $criteria->compare('cancel_by_whom', $this->cancel_by_whom, true);
        $criteria->compare('cancel_requested_by', $this->cancel_requested_by, true);

        $criteria->addInCondition('t.booking_id', Utility::getCancelledBookingForStaff($_SESSION['logged_user']['id']));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StaffBooking the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
