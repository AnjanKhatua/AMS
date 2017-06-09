<?php

/**
 * This is the model class for table "{{job_type_for_finance}}".
 *
 * The followings are the available columns in table '{{job_type_for_finance}}':
 * @property string $id
 * @property string $job_type_id
 * @property string $job_type
 * @property string $status
 */
class JobTypeForFinance extends CActiveRecord {

    public $job_type;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{job_type_for_finance}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('job_type_id, job_type_name, status', 'required'),
            array('job_type_id', 'length', 'max' => 10),
            array('job_type_name', 'length', 'max' => 255),
            array('status', 'length', 'max' => 1),
            array('job_type_name', 'unique'),
            array('job_type', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, job_type_id, job_type_name, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'jobType' => array(self::BELONGS_TO, 'JobType', 'job_type_id'),
            'staffJobTypeRate' => array(self::HAS_MANY, 'StaffJobTypeRate', 'id'),
            'hospitalJobTypeRate' => array(self::HAS_MANY, 'HospitalJobTypeRate', 'id'),
            'timesheet' => array(self::HAS_MANY, 'Timesheet', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'job_type_id' => 'Job Type',
            'job_type_name' => 'Job Type Name for Finance',
            'status' => 'Status',
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

        $criteria->with = array('jobType');
        $criteria->compare('jobType.job_type', $this->job_type, true);
        $criteria->compare('id', $this->id, true);
        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('job_type_name', $this->job_type_name, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "t.id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JobTypeForFinance the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function jobTypeOfFinance() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{job_type_for_finance}} WHERE `status`='Y'")->queryAll();
        $la_job = array();
        foreach ($command as $lo_job) {
            $key = $lo_job['id'];
            $value = $lo_job['job_type_name'];
            $la_job[$key] = $value;
        }
        return $la_job;
    }

}
