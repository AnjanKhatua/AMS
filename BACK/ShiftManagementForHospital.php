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
class ShiftManagementForHospital extends CActiveRecord
{
	
	public $hospital_unit_name;	
	public $job_type;
	public $user;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shift_management_for_hospital}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('hospital_unit_id, job_type_id, quantity, date, shift_start_time, shift_end_time, requested_date, requested_time, requested_person, request_accepted_by, requested_person_mobile_number', 'required'),
			array('hospital_unit_id, job_type_id, request_accepted_by', 'length', 'max'=>10),
			array('quantity', 'length', 'max'=>3),
			array('requested_person', 'length', 'max'=>150),
			array('requested_person_mobile_number', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('requested_time', 'requestTimeVerification'),
			array('requested_person', 'requestedPersonVerification'),
			array('request_accepted_by', 'userVerification'),
			array('requested_person_mobile_number', 'contactVerification'),
			array('staff_request_id, hospital_unit_id, job_type_id, quantity, date, shift_start_time, shift_end_time, requested_date, requested_time, requested_person, request_accepted_by, requested_person_mobile_number', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'bookings' => array(self::HAS_MANY, 'Booking', 'staff_request_id'),
			'enquiries' => array(self::HAS_MANY, 'Enquiry', 'staff_request_id'),
			'hospitalUnit' => array(self::BELONGS_TO, 'HospitalUnit', 'hospital_unit_id'),
			'jobType' => array(self::BELONGS_TO, 'JobType', 'job_type_id'),
			'requestAcceptedBy' => array(self::BELONGS_TO, 'User', 'request_accepted_by'),
			'staffRequestRequiredTrainingMapTables' => array(self::HAS_MANY, 'StaffRequestRequiredTrainingMapTable', 'request_id'),
		);
	}
	/*
     * @Requested time verification.
     */
    public function requestTimeVerification($attribute, $params) {
        $tm = $this->$attribute;
        $countTm = strlen($tm);
        
        if ($countTm == 0) {
            $this->addError($attribute, 'Please choose name!');
        }
    }
	/*
     * @Requested person verification.
     */
    public function requestedPersonVerification($attribute, $params) {
        $per = $this->$attribute;
        $countPer = strlen($per);
        
        if ($countPer == 0) {
            $this->addError($attribute, 'Please enter requested person name!');
        }
    }
	/*
     * @User selection.
     */
    public function userVerification($attribute, $params) {
        $hospitalArea = $this->$attribute;
        $count = strlen($hospitalArea);
        if ($count == 0) {
            $this->addError($attribute, 'Please select an user!');
        } 
    }
    /*
     * @Contact number varification.
     */
    public function contactVerification($attribute, $params) {
        $contactNumber = $this->$attribute;
        $countContactNumber = strlen($contactNumber);
        if ($countContactNumber == 0) {
            $this->addError($attribute, 'Please enter mobile number!');
        } else if (!preg_match('/^[1-9][0-9]{0,10}$/', $contactNumber)) {
            $this->addError($attribute, 'Please enter valid contact number!');
        } else if (strlen($contactNumber) != 10) {
            $this->addError($attribute, 'Please enter 10 digit mobile number!');
        }
    }
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'staff_request_id' => 'Staff Name',
			'hospital_unit_id' => 'Hospital Name',
			'job_type_id' => 'Job Type',
			'quantity' => 'Quantity',
			'date' => 'Date',
			'shift_start_time' => 'Shift Start Time',
			'shift_end_time' => 'Shift End Time',
			'requested_date' => 'Requested Date',
			'requested_time' => 'Requested Time',
			'requested_person' => 'Requested Person',
			'request_accepted_by' => 'Request Accepted By',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('staff_request_id',$this->staff_request_id,true);
		$criteria->compare('hospital_unit_id',$this->hospital_unit_id,true);
		$criteria->compare('job_type_id',$this->job_type_id,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('shift_start_time',$this->shift_start_time,true);
		$criteria->compare('shift_end_time',$this->shift_end_time,true);
		$criteria->compare('requested_date',$this->requested_date,true);
		$criteria->compare('requested_time',$this->requested_time,true);
		$criteria->compare('requested_person',$this->requested_person,true);
		$criteria->compare('request_accepted_by',$this->request_accepted_by,true);
		$criteria->compare('requested_person_mobile_number',$this->requested_person_mobile_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShiftManagementForHospital the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
