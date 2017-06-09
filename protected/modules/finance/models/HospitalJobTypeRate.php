<?php

/**
 * This is the model class for table "{{hospital_job_type_rate_map}}".
 *
 * The followings are the available columns in table '{{hospital_job_type_rate_map}}':
 * @property string $id
 * @property string $hospital_unit_id
 * @property string $finance_job_type_id
 * @property double $rate
 */
class HospitalJobTypeRate extends CActiveRecord {

    public $hospital_unit;
    public $job_type_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{hospital_job_type_rate_map}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hospital_unit_id, finance_job_type_id, rate, pay_rate_for_staffs', 'required'),
            array('rate, pay_rate_for_staffs', 'numerical'),
            array('hospital_unit_id, finance_job_type_id', 'length', 'max' => 10),
            array('hospital_unit, job_type_name', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, hospital_unit_id, finance_job_type_id, rate, pay_rate_for_staffs', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'hospitalUnit' => array(self::BELONGS_TO, 'HospitalUnit', 'hospital_unit_id'),
            'jobType' => array(self::BELONGS_TO, 'JobTypeForFinance', 'finance_job_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'hospital_unit_id' => 'Hospital Unit',
            'finance_job_type_id' => 'Finance Job Type',
            'hospital_unit' => 'Hospital Unit',
            'job_type_name' => 'Finance Job Type',
            'rate' => 'Rate',
            'pay_rate_for_staffs' => 'Pay Rate For Staffs',
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

        $criteria->with = array('hospitalUnit', 'jobType');
        $criteria->compare('jobType.job_type_name', $this->job_type_name, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('finance_job_type_id', $this->finance_job_type_id, true);
        $criteria->compare('rate', $this->rate);
        $criteria->compare('pay_rate_for_staffs', $this->pay_rate_for_staffs);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "t.id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HospitalJobTypeRate the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function allHospital() {
        $command = Yii::app()->db->createCommand("SELECT h.hospital_unit_id, h.hospital_unit FROM {{hospital_unit}} h, {{hospital_job_type_rate_map}} hm WHERE h.hospital_unit_id = hm.hospital_unit_id AND  h.hospital_unit_active_status='Y' ORDER BY h.hospital_unit")->queryAll();
        $la_hos = array("" => "Select One");
        foreach ($command as $lo_user) {
            $key = $lo_user['hospital_unit_id'];
            $value = $lo_user['hospital_unit'];
            $la_hos[$key] = $value;
        }
        return $la_hos;
    }

}
