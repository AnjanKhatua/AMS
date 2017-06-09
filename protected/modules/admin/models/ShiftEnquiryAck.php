<?php

/**
 * This is the model class for table "{{shift_enquiry_ack}}".
 *
 * The followings are the available columns in table '{{shift_enquiry_ack}}':
 * @property string $enquiry_id
 * @property string $staff_request_id
 * @property string $staff_id
 * @property string $enquired_by
 * @property string $availability_confirmed_by_staff
 * @property string $availability_confirmed_via
 * @property string $confirmed_by
 * @property string $agent_user_id
 * @property string $is_confirmed
 *
 * The followings are the available model relations:
 * @property User $agentUser
 * @property ShiftManagementForHospital $staffRequest
 * @property StaffRegistration $staff
 */
class ShiftEnquiryAck extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shift_enquiry_ack}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staff_request_id, staff_id, enquired_by, confirmed_by', 'required'),
			array('staff_request_id, staff_id, enquired_by, agent_user_id', 'length', 'max'=>10),
			array('availability_confirmed_by_staff, confirmed_by, is_confirmed', 'length', 'max'=>2),
			array('availability_confirmed_via', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('enquiry_id, staff_request_id, staff_id, enquired_by, availability_confirmed_by_staff, availability_confirmed_via, confirmed_by, agent_user_id, is_confirmed', 'safe', 'on'=>'search'),
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
			'agentUser' => array(self::BELONGS_TO, 'User', 'agent_user_id'),
			'staffRequest' => array(self::BELONGS_TO, 'ShiftManagementForHospital', 'staff_request_id'),
			'staff' => array(self::BELONGS_TO, 'StaffRegistration', 'staff_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'enquiry_id' => 'Enquiry',
			'staff_request_id' => 'Staff Request',
			'staff_id' => 'Staff',
			'enquired_by' => 'Enquired By',
			'availability_confirmed_by_staff' => 'Availability Confirmed By Staff',
			'availability_confirmed_via' => 'Availability Confirmed Via',
			'confirmed_by' => 'Confirmed By',
			'agent_user_id' => 'Agent User',
			'is_confirmed' => 'Is Confirmed',
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

		$criteria->compare('enquiry_id',$this->enquiry_id,true);
		$criteria->compare('staff_request_id',$this->staff_request_id,true);
		$criteria->compare('staff_id',$this->staff_id,true);
		$criteria->compare('enquired_by',$this->enquired_by,true);
		$criteria->compare('availability_confirmed_by_staff',$this->availability_confirmed_by_staff,true);
		$criteria->compare('availability_confirmed_via',$this->availability_confirmed_via,true);
		$criteria->compare('confirmed_by',$this->confirmed_by,true);
		$criteria->compare('agent_user_id',$this->agent_user_id,true);
		$criteria->compare('is_confirmed',$this->is_confirmed,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShiftEnquiryAck the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
