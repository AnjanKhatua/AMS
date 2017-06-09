<?php

/**
 * This is the model class for table "{{training_details}}".
 *
 * The followings are the available columns in table '{{training_details}}':
 * @property string $id
 * @property string $training_id
 * @property string $staff_id
 * @property string $fees_paid_date
 * @property double $fees
 * @property string $deduction_amount
 * @property double $remaining_amount
 */
class TrainingDetails extends CActiveRecord {

    public $course_name;
    public $email;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{training_details}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('training_id, staff_id, fees, deduction_amount, remaining_amount', 'required'),
            array('fees, remaining_amount', 'numerical'),
            array('training_id, staff_id', 'length', 'max' => 10),
            array('deduction_amount', 'length', 'max' => 10),
            array('course_name, email', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, training_id, staff_id, fees_paid_date, fees, deduction_amount, remaining_amount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'allTrainings' => array(self::BELONGS_TO, 'AllTraining', 'training_id'),
            'staff' => array(self::BELONGS_TO, 'User', 'staff_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'training_id' => 'Training Name',
            'course_name' => 'Training Name',
            'staff_id' => 'Staff',
            'email' => 'Staff',
            'fees_paid_date' => 'Fees Paid Dates',
            'fees' => 'Total Fees',
            'deduction_amount' => 'Deduction Amount',
            'remaining_amount' => 'Remaining Amount',
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
        $criteria->with = array('allTrainings', 'staff');
        $criteria->compare('allTrainings.course_name', $this->course_name, true);
        $criteria->compare('staff.email', $this->email, true);

        $criteria->compare('id', $this->id, true);
        $criteria->compare('training_id', $this->training_id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('fees_paid_date', $this->fees_paid_date, true);
        $criteria->compare('fees', $this->fees);
        $criteria->compare('deduction_amount', $this->deduction_amount, true);
        $criteria->compare('remaining_amount', $this->remaining_amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "t.id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TrainingDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
