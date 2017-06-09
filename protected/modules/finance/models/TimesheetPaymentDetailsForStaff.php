<?php

/**
 * This is the model class for table "{{timesheet_payment_details_for_staff}}".
 *
 * The followings are the available columns in table '{{timesheet_payment_details_for_staff}}':
 * @property string $id
 * @property string $staff_id
 * @property string $invoice_date
 * @property string $week_end_date
 * @property double $total_amount
 * @property double $training_deduction_amount
 * @property double $net_amount
 * @property string $training_deduction_apply
 * @property string $paid_status
 */
class TimesheetPaymentDetailsForStaff extends CActiveRecord {

    public $first_name;
    public $last_name;

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
            array('staff_id, invoice_date, week_end_date, total_amount, training_deduction_amount, net_amount, training_deduction_apply, paid_status', 'required'),
            array('total_amount, training_deduction_amount, net_amount', 'numerical'),
            array('staff_id', 'length', 'max' => 10),
            array('training_deduction_apply, paid_status', 'length', 'max' => 1),
            array('first_name, last_name', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, staff_id, invoice_date, week_end_date, total_amount, training_deduction_amount, net_amount, training_deduction_apply, paid_status', 'safe', 'on' => 'search'),
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'invoice_date' => 'Invoice Date',
            'week_end_date' => 'Week End Date',
            'total_amount' => 'Total Amount',
            'training_deduction_amount' => 'Training Deduction',
            'net_amount' => 'Net Amount',
            'training_deduction_apply' => 'Deduction Apply',
            'paid_status' => 'Paid Status',
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
        $criteria->compare('user.first_name', $this->first_name, true);
        $criteria->compare('user.last_name', $this->last_name, true);
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('invoice_date', $this->invoice_date, true);
        $criteria->compare('week_end_date', $this->week_end_date, true);
        $criteria->compare('total_amount', $this->total_amount);
        $criteria->compare('training_deduction_amount', $this->training_deduction_amount);
        $criteria->compare('net_amount', $this->net_amount);
        $criteria->compare('training_deduction_apply', $this->training_deduction_apply, true);
        $criteria->compare('paid_status', $this->paid_status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "t.id DESC")
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
