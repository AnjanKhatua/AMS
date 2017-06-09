<?php

/**
 * This is the model class for table "{{timesheet}}".
 *
 * The followings are the available columns in table '{{timesheet}}':
 * @property string $id
 * @property string $staff_id
 * @property string $hospital_unit_id
 * @property string $week_end_date
 * @property string $finance_job_type_id
 * @property double $monday
 * @property double $tuesday
 * @property double $wednesday
 * @property double $thursday
 * @property double $friday
 * @property double $saturday
 * @property double $sunday
 * @property double $total_worked_hours
 * @property double $exp
 * @property double $total_amount_of_staff
 * @property string $note
 * @property string $paid_to_staff
 * @property string $paid_by_hospital
 */
class Timesheet extends CActiveRecord {

    public $job_type_name;
    public $hospital_unit;
    public $first_name;
    public $last_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{timesheet}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('staff_id, hospital_unit_id, invoice_date, week_end_date, finance_job_type_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, exp', 'required'),
            array('monday, tuesday, wednesday, thursday, friday, saturday, sunday, total_worked_hours, exp, total_amount_of_staff, total_amount_of_hospital', 'numerical'),
            array('staff_id, hospital_unit_id, finance_job_type_id', 'length', 'max' => 10),
            array('paid_to_staff, paid_by_hospital', 'length', 'max' => 1),
            array('job_type_name, hospital_unit, first_name, last_name', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, staff_id, hospital_unit_id, invoice_date, week_end_date, finance_job_type_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, total_worked_hours, exp, total_amount_of_staff, total_amount_of_hospital, note, paid_to_staff, paid_by_hospital', 'safe', 'on' => 'search'),
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
            'staff_id' => 'Staff',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'hospital_unit_id' => 'Hospital',
            'invoice_date' => 'Invoice Date',
            'week_end_date' => 'Week End Date',
            'finance_job_type_id' => 'Job Type',
            'monday' => 'Mon',
            'tuesday' => 'Tue',
            'wednesday' => 'Wed',
            'thursday' => 'Thu',
            'friday' => 'Fri',
            'saturday' => 'Sat',
            'sunday' => 'Sun',
            'total_worked_hours' => 'Worked Hours',
            'exp' => 'Exp',
            'total_amount_of_staff' => 'Amount',
            'total_amount_of_hospital' => "Hospital's Amount",
            'note' => 'Notes',
            'paid_to_staff' => 'Paid To Staff',
            'paid_by_hospital' => 'Paid By Hospital',
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

        $criteria->with = array('jobType', 'hospitalUnit', 'user');
        $criteria->compare('jobType.job_type_name', $this->job_type_name, true);
        $criteria->compare('hospitalUnit.hospital_unit', $this->hospital_unit, true);
        $criteria->compare('user.first_name', $this->first_name, true);
        $criteria->compare('user.last_name', $this->last_name, true);
        $criteria->compare('id', $this->id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('hospital_unit_id', $this->hospital_unit_id, true);
        $criteria->compare('DATE_FORMAT(invoice_date,"%d-%m-%Y %H:%i:%s")', $this->invoice_date, true);
        $criteria->compare('DATE_FORMAT(week_end_date,"%d-%m-%Y %H:%i:%s")', $this->week_end_date, true);
//        $criteria->compare('week_end_date', $this->week_end_date, true);
        $criteria->compare('finance_job_type_id', $this->finance_job_type_id, true);
        $criteria->compare('monday', $this->monday);
        $criteria->compare('tuesday', $this->tuesday);
        $criteria->compare('wednesday', $this->wednesday);
        $criteria->compare('thursday', $this->thursday);
        $criteria->compare('friday', $this->friday);
        $criteria->compare('saturday', $this->saturday);
        $criteria->compare('sunday', $this->sunday);
        $criteria->compare('total_worked_hours', $this->total_worked_hours);
        $criteria->compare('exp', $this->exp);
        $criteria->compare('total_amount_of_staff', $this->total_amount_of_staff);
        $criteria->compare('total_amount_of_hospital', $this->total_amount_of_hospital);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('paid_to_staff', $this->paid_to_staff, true);
        $criteria->compare('paid_by_hospital', $this->paid_by_hospital, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "t.id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Timesheet the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
