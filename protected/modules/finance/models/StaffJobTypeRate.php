<?php

/**
 * This is the model class for table "{{staff_job_type_rate_map}}".
 *
 * The followings are the available columns in table '{{staff_job_type_rate_map}}':
 * @property string $id
 * @property string $staff_id
 * @property string $finance_job_type_id
 * @property double $rate
 */
class StaffJobTypeRate extends CActiveRecord {

    public $first_name;
    public $last_name;
    public $job_type_name;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{staff_job_type_rate_map}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('staff_id, finance_job_type_id, rate', 'required'),
            array('rate', 'numerical'),
            array('staff_id, finance_job_type_id', 'length', 'max' => 10),
            array('first_name, last_name, job_type_name', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, staff_id, finance_job_type_id, rate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'staff_id'),
            'jobType' => array(self::BELONGS_TO, 'JobTypeForFinance', 'finance_job_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'staff_id' => 'Staff',
            'finance_job_type_id' => 'Finance Job Type',
            'email' => 'Staff',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'job_type_name' => 'Finance Job Type',
            'rate' => 'Rate',
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

        $criteria->with = array('user', 'jobType');
        $criteria->compare('jobType.job_type_name', $this->job_type_name, true);
        $criteria->compare('user.first_name', $this->first_name, true);
        $criteria->compare('user.last_name', $this->last_name, true);
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('finance_job_type_id', $this->finance_job_type_id, true);
        $criteria->compare('rate', $this->rate);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "t.id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StaffJobTypeRate the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
