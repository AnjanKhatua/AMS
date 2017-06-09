<?php

/**
 * This is the model class for table "{{uploaded_timesheet_by_staff}}".
 *
 * The followings are the available columns in table '{{uploaded_timesheet_by_staff}}':
 * @property string $id
 * @property string $staff_id
 * @property string $ip
 * @property string $week_end_date
 * @property string $upload_date_time
 * @property string $timesheet_name
 */
class UploadedTimesheetByStaff extends CActiveRecord {

    public $email;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{uploaded_timesheet_by_staff}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('staff_id, ip, week_end_date, upload_date_time, timesheet_name', 'required'),
            array('staff_id', 'length', 'max' => 10),
            array('ip', 'length', 'max' => 32),
            array('timesheet_name', 'length', 'max' => 255),
            array('email', 'length', 'min' => 0),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, staff_id, ip, week_end_date, upload_date_time, timesheet_name', 'safe', 'on' => 'search'),
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
            'ip' => 'IP',
            'week_end_date' => 'Week End Date',
            'upload_date_time' => 'Upload Date Time',
            'timesheet_name' => 'Timesheet Name',
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
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('week_end_date', $this->week_end_date, true);
        $criteria->compare('upload_date_time', $this->upload_date_time, true);
        $criteria->compare('timesheet_name', $this->timesheet_name, true);
        
        $criteria->addInCondition('t.staff_id', array($_SESSION['logged_user']['id']));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "t.id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UploadedTimesheetByStaff the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
