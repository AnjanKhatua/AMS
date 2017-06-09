<?php

/**
 * This is the model class for table "{{staff_registration_preferred_work_area_map_table}}".
 *
 * The followings are the available columns in table '{{staff_registration_preferred_work_area_map_table}}':
 * @property string $id
 * @property string $staff_id
 * @property string $work_area_id
 *
 * The followings are the available model relations:
 * @property StaffRegistration $staff
 * @property WorkArea $workArea
 */
class StaffRegistrationPreferredWorkAreaMapTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{staff_registration_preferred_work_area_map_table}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staff_id, work_area_id', 'required'),
			array('staff_id', 'length', 'max'=>11),
			array('work_area_id', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staff_id, work_area_id', 'safe', 'on'=>'search'),
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
			'workArea' => array(self::BELONGS_TO, 'WorkArea', 'work_area_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'staff_id' => 'Staff',
			'work_area_id' => 'Work Area',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('staff_id',$this->staff_id,true);
		$criteria->compare('work_area_id',$this->work_area_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffRegistrationPreferredWorkAreaMapTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
