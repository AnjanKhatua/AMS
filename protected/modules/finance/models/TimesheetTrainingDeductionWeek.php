<?php

/**
 * This is the model class for table "{{timesheet_training_deduction_week}}".
 *
 * The followings are the available columns in table '{{timesheet_training_deduction_week}}':
 * @property string $id
 * @property string $staff_id
 * @property string $invoice_date
 * @property string $week_end_date
 * @property string $apply_status
 */
class TimesheetTrainingDeductionWeek extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{timesheet_training_deduction_week}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('staff_id, invoice_date, week_end_date, apply_status', 'required'),
            array('staff_id', 'length', 'max' => 10),
            array('apply_status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, staff_id, invoice_date, week_end_date, apply_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'staff_id' => 'Staff',
            'invoice_date' => 'Invoice Date',
            'week_end_date' => 'Week End Date',
            'apply_status' => 'Apply Status',
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
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('invoice_date', $this->invoice_date, true);
        $criteria->compare('week_end_date', $this->week_end_date, true);
        $criteria->compare('apply_status', $this->apply_status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TimesheetTrainingDeductionWeek the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
