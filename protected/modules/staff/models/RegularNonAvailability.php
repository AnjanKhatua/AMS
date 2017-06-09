<?php

/**
 * This is the model class for table "{{regular_non_availability_of_staff}}".
 *
 * The followings are the available columns in table '{{regular_non_availability_of_staff}}':
 * @property string $id
 * @property string $non_availablility_id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 */
class RegularNonAvailability extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{regular_non_availability_of_staff}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('non_availablility_id, date, start_time, end_time', 'required'),
            array('non_availablility_id', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, non_availablility_id, date, start_time, end_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'nonAvailablility' => array(self::BELONGS_TO, 'NonAvailability', 'non_availablility_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'non_availablility_id' => 'Non Availablility',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
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
        $criteria->compare('non_availablility_id', $this->non_availablility_id, true);
        $criteria->compare('DATE_FORMAT(date,"%d-%m-%Y")', $this->date, true);
        $criteria->compare('start_time', $this->start_time, true);
        $criteria->compare('end_time', $this->end_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegularNonAvailability the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
