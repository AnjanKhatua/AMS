<?php

/**
 * This is the model class for table "{{all_training}}".
 *
 * The followings are the available columns in table '{{all_training}}':
 * @property string $id
 * @property string $course_name
 * @property double $fees
 * @property string $active_status
 */
class AllTraining extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{all_training}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_name, fees, active_status', 'required'),
            array('fees', 'numerical'),
            array('course_name', 'length', 'max' => 255),
            array('active_status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, course_name, fees, active_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'trainingDetails' => array(self::HAS_MANY, 'TrainingDetails', 'id'),
            'hospitalUnit' => array(self::HAS_MANY, 'HospitalUnit', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'course_name' => 'Course Name',
            'fees' => 'Fees',
            'active_status' => 'Active Status',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('course_name', $this->course_name, true);
        $criteria->compare('fees', $this->fees);
        $criteria->compare('active_status', $this->active_status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AllTraining the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function trainingTypeAll() {

        $command = Yii::app()->db->createCommand("SELECT * FROM {{all_training}} WHERE `active_status`='Y' ORDER BY `course_name`")->queryAll();
        $la_training = array('' => "Select One");
        foreach ($command as $lo_training) {
            $key = $lo_training['id'];
            $value = $lo_training['course_name'];
            $la_training[$key] = $value;
        }
        return $la_training;
    }

}
