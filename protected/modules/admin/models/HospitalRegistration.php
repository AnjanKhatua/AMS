<?php

/**
 * This is the model class for table "{{hospital_registration}}".
 *
 * The followings are the available columns in table '{{hospital_registration}}':
 * @property string $hospital_id
 * @property string $hospital_name
 * @property string $hospital_status
 */
class HospitalRegistration extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{hospital_registration}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hospital_name', 'required', 'message' => 'Please enter {attribute}.'),
			array('hospital_name', 'length', 'max'=>255),
			array('hospital_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('hospital_name', 'nameVerification'),
			array('hospital_id, hospital_name, hospital_status', 'safe', 'on'=>'search'),
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
                       'hospitalUnit' => array(self::HAS_MANY, 'HospitalUnit', 'hospital_id'),
		);
	}
    /*
     * @Hospital name validation for server side.
     */
    public function nameVerification($attribute, $params) {
        $hospitalName = $this->$attribute;
		$countName = strlen($hospitalName);
		$pattern = '/^([A-Z])+(([a-zA-Z0-9\s])+)+$/';
        if ($countName < 4) {
            $this->addError($attribute, 'Hospital group name should be more than 4 characters!');
        } else if (!preg_match($pattern, $hospitalName)) {
            $this->addError($attribute, 'First letter should be capital and does not contain any special character!');
        }
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hospital_id' => 'Hospital',
			'hospital_name' => 'Hospital Group',
			'hospital_status' => 'Hospital Status',
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

		$criteria->compare('hospital_id',$this->hospital_id,true);
		$criteria->compare('hospital_name',$this->hospital_name,true);
		$criteria->compare('hospital_status',$this->hospital_status,true);

		return new CActiveDataProvider($this, array(
		    'criteria' => $criteria,
		    'sort'=>array("defaultOrder"=>"hospital_id DESC")
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HospitalRegistration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function hospitalAll() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{hospital_registration}} WHERE `hospital_status`='A' order by hospital_name")->queryAll();
        $la_hos = array('' => "Select hospital");
        foreach ($command as $lo_user) {
            $key = $lo_user['hospital_id'];
            $value = $lo_user['hospital_name'];
            $la_hos[$key] = $value;
        }

        return $la_hos;
    }

}
