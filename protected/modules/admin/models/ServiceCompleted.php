<?php

/**
 * This is the model class for table "{{service_completed}}".
 *
 * The followings are the available columns in table '{{service_completed}}':
 * @property string $service_id
 * @property string $staff_id
 * @property string $enquiry_id
 * @property string $hospital_unit_id
 * @property string $booking_id
 * @property string $date
 * @property string $shift_start_time
 * @property string $shift_end_time
 * @property string $staff_category
 *
 * The followings are the available model relations:
 * @property StaffRegistration $staff
 * @property Enquiry $enquiry
 * @property Booking $booking
 * @property HospitalUnit $hospitalUnit
 */
class ServiceCompleted extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service_completed}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staff_id, enquiry_id, hospital_unit_id, booking_id, date, shift_start_time, shift_end_time, staff_category', 'required'),
			array('staff_id, enquiry_id, hospital_unit_id', 'length', 'max'=>10),
			array('booking_id', 'length', 'max'=>11),
			array('staff_category', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('service_id, staff_id, enquiry_id, hospital_unit_id, booking_id, date, shift_start_time, shift_end_time, staff_category', 'safe', 'on'=>'search'),
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
			'staff' => array(self::BELONGS_TO, 'StaffRegistration', 'staff_id'),
			'enquiry' => array(self::BELONGS_TO, 'Enquiry', 'enquiry_id'),
			'booking' => array(self::BELONGS_TO, 'Booking', 'booking_id'),
			'hospitalUnit' => array(self::BELONGS_TO, 'HospitalUnit', 'hospital_unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'service_id' => 'Service',
			'staff_id' => 'Staff',
			'enquiry_id' => 'Enquiry',
			'hospital_unit_id' => 'Hospital Unit',
			'booking_id' => 'Booking',
			'date' => 'Date',
			'shift_start_time' => 'Shift Start Time',
			'shift_end_time' => 'Shift End Time',
			'staff_category' => 'Staff Category',
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

		$criteria->compare('service_id',$this->service_id,true);
		$criteria->compare('staff_id',$this->staff_id,true);
		$criteria->compare('enquiry_id',$this->enquiry_id,true);
		$criteria->compare('hospital_unit_id',$this->hospital_unit_id,true);
		$criteria->compare('booking_id',$this->booking_id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('shift_start_time',$this->shift_start_time,true);
		$criteria->compare('shift_end_time',$this->shift_end_time,true);
		$criteria->compare('staff_category',$this->staff_category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceCompleted the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
