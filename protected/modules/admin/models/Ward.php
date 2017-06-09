<?php

/**
 * This is the model class for table "{{ward}}".
 *
 * The followings are the available columns in table '{{ward}}':
 * @property string $ward_id
 * @property string $ward_name
 *
 * The followings are the available model relations:
 * @property WardHospitalUnitMap[] $wardHospitalUnitMaps
 */
class Ward extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ward}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ward_name', 'required'),
			array('ward_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ward_name', 'wardVerification'),
			array('ward_id, ward_name', 'safe', 'on'=>'search'),
		);
	}
	/*
     * @Ward validation for server side.
     */
    public function wardVerification($attribute, $params) {
        $wardName = $this->$attribute;
        $countName = strlen($wardName);
        $pattern = '/^([A-Z])+(([a-zA-Z0-9\&\-\/\s])+)+$/';
        if ($countName < 2) {
            $this->addError($attribute, 'Ward name should be greater than 2 characters!');
        } else if (!preg_match($pattern, $wardName)) {
            $this->addError($attribute, 'First character of a ward should be capital and special character not allow!');
        }
    }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'wardHospitalUnitMaps' => array(self::HAS_MANY, 'WardHospitalUnitMap', 'ward_id'),
    			'shiftManagementForHospital' => array(self::HAS_MANY, 'ShiftManagementForHospital', 'ward_id'),
    			'availableShiftForHospital' => array(self::HAS_MANY, 'AvailableShiftForHospital', 'ward_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ward_id' => 'Ward',
			'ward_name' => 'Ward Name',
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

		$criteria->compare('ward_id',$this->ward_id,true);
		$criteria->compare('ward_name',$this->ward_name,true);

		return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort'=>array("defaultOrder"=>"ward_id DESC")
                ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ward the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function allWards() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{ward}}")->queryAll();
        $la_ward = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['ward_id'];
            $value = $lo_user['ward_name'];
            $la_ward[$key] = $value;
        }

        return $la_ward;
    }
    public function allSelectedWards($li_unitId) {
    	$command = Yii::app()->db->createCommand("SELECT `ward_id` FROM {{ward_hospital_unit_map}} WHERE `hospital_unit_id`=".$li_unitId)->queryAll();
    	//print_r($command);
    	$la_ward = array();
    	foreach ($command as $rec) {
    
    		$command1 = $command = Yii::app()->db->createCommand("SELECT * FROM {{ward}} WHERE `ward_id`=".$rec['ward_id'])->queryAll();
    
    		$key = $command1[0]['ward_id'];
    		$value = $command1[0]['ward_name'];
    		$la_ward[$key] = $value;
    	}
    	//print_r($la_ward);die;
    	return $la_ward;
    }
    public function selectedWards($li_unitId)
    {
        $ls_sql = "SELECT group_concat(ward_id) FROM {{ward_hospital_unit_map}} WHERE `hospital_unit_id`=".$li_unitId;
        return $ls_res = Yii::app()->db->createCommand($ls_sql)->queryScalar();
     }
}
