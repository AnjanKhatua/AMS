<?php

/**
 * This is the model class for table "{{ward_hospital_unit_map}}".
 *
 * The followings are the available columns in table '{{ward_hospital_unit_map}}':
 * @property integer $id
 * @property string $hospital_unit_id
 * @property string $ward_id
 *
 * The followings are the available model relations:
 * @property Ward $ward
 * @property HospitalUnit $hospitalUnit
 */
class WardHospitalUnitMap extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ward_hospital_unit_map}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hospital_unit_id, ward_id', 'required'),
			array('hospital_unit_id', 'length', 'max'=>10),
			array('ward_id', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hospital_unit_id, ward_id', 'safe', 'on'=>'search'),
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
			'ward' => array(self::BELONGS_TO, 'Ward', 'ward_id'),
			'hospitalUnit' => array(self::BELONGS_TO, 'HospitalUnit', 'hospital_unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hospital_unit_id' => 'Hospital Unit',
			'ward_id' => 'Ward',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('hospital_unit_id',$this->hospital_unit_id,true);
		$criteria->compare('ward_id',$this->ward_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WardHospitalUnitMap the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
