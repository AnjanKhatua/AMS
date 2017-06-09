<?php

/**
 * This is the model class for table "{{job_type}}".
 *
 * The followings are the available columns in table '{{job_type}}':
 * @property string $job_type_id
 * @property string $job_type
 * @property string $job_type_active_status
 *
 * The followings are the available model relations:
 * @property ShiftManagementForHospital[] $shiftManagementForHospitals
 * @property StaffRegistration[] $staffRegistrations
 */
class JobType extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{job_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('job_type', 'required'),
            array('job_type', 'length', 'max' => 255),
            array('job_type_active_status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('job_type_id, job_type, job_type_active_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'shiftManagementForHospitals' => array(self::HAS_MANY, 'ShiftManagementForHospital', 'job_type_id'),
            'jobTypeForFinance' => array(self::HAS_MANY, 'JobTypeForFinance', 'job_type_id'),
            'availableShiftForHospital' => array(self::HAS_MANY, 'AvailableShiftForHospital', 'job_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'job_type_id' => 'Job Type',
            'job_type' => 'Job Type',
            'job_type_active_status' => 'Job Type Active Status',
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

        $criteria->compare('job_type_id', $this->job_type_id, true);
        $criteria->compare('job_type', $this->job_type, true);
        $criteria->compare('job_type_active_status', $this->job_type_active_status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array("defaultOrder"=>"job_type_id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JobType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function jobTypeAll() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{job_type}} WHERE `job_type_active_status`='Y'")->queryAll();
        $la_area = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['job_type_id'];
            $value = $lo_user['job_type'];
            $la_area[$key] = $value;
        }
//       print_r($la_hos);
//        die();
        return $la_area;
    }
    
        public function jobTypeAllForFinance() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{job_type}} WHERE `job_type_active_status`='Y'")->queryAll();
        $la_job = array(''=>'Select Job Type');
        foreach ($command as $lo_job) {
            $key = $lo_job['job_type_id'];
            $value = $lo_job['job_type'];
            $la_job[$key] = $value;
        }
//       print_r($la_hos);
//        die();
        return $la_job;
    }

}
