<?php

/**
 * This is the model class for table "{{timesheet_payment_details_for_staff}}".
 *
 * The followings are the available columns in table '{{timesheet_payment_details_for_staff}}':
 * @property string $id
 * @property string $staff_id
 * @property string $week_end_date
 * @property double $total_amount
 * @property double $for_training_deduction
 * @property double $payment_amount
 * @property double $remaining_amount
 */
class TimesheetPaymentDetailsForStaff extends CActiveRecord {

    public $email;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{timesheet_payment_details_for_staff}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('staff_id, week_end_date, total_amount, for_training_deduction, payment_amount', 'required'),
            array('total_amount, for_training_deduction, payment_amount, remaining_amount', 'numerical'),
            array('staff_id', 'length', 'max' => 10),
            array('email', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, staff_id, week_end_date, total_amount, for_training_deduction, payment_amount, remaining_amount', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'staff_id' => 'Staff',
            'week_end_date' => 'Week End Date',
            'total_amount' => 'Total Amount',
            'for_training_deduction' => 'For Training Deduction',
            'payment_amount' => 'Payment Amount',
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

        $criteria->with = array('user');
        $criteria->compare('user.email', $this->email, true);
        $criteria->compare('id', $this->id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('week_end_date', $this->week_end_date, true);
        $criteria->compare('total_amount', $this->total_amount);
        $criteria->compare('for_training_deduction', $this->for_training_deduction);
        $criteria->compare('payment_amount', $this->payment_amount);
        $criteria->compare('remaining_amount', $this->remaining_amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TimesheetPaymentDetailsForStaff the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
