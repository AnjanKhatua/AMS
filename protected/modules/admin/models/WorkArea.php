<?php

/**
 * This is the model class for table "{{work_area}}".
 *
 * The followings are the available columns in table '{{work_area}}':
 * @property string $work_area_id
 * @property string $area_name
 * @property string $area_active_status
 *
 * The followings are the available model relations:
 * @property StaffRegistrationPreferredWorkAreaMapTable[] $staffRegistrationPreferredWorkAreaMapTables
 */
class WorkArea extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{work_area}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('area_name', 'required'),
            array('area_name', 'length', 'max' => 150),
            array('area_active_status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('work_area_id, area_name, area_active_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'staffRegistrationPreferredWorkAreaMapTables' => array(self::HAS_MANY, 'StaffRegistrationPreferredWorkAreaMapTable', 'work_area_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'work_area_id' => 'Work Area',
            'area_name' => 'Area Name',
            'area_active_status' => 'Area Active Status',
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

        $criteria->compare('work_area_id', $this->work_area_id, true);
        $criteria->compare('area_name', $this->area_name, true);
        $criteria->compare('area_active_status', $this->area_active_status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array("defaultOrder"=>"work_area_id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkArea the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function workPlaceAll() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{work_area}} WHERE `area_active_status`='Y'")->queryAll();
        $la_area = array('' => "Select work place");
        foreach ($command as $lo_user) {
            $key = $lo_user['work_area_id'];
            $value = $lo_user['area_name'];
            $la_area[$key] = $value;
        }
//       print_r($la_hos);
//        die();
        return $la_area;
    }
    
    public function workPlaceCheckAll() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{work_area}} WHERE `area_active_status`='Y'")->queryAll();
        $la_area = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['work_area_id'];
            $value = $lo_user['area_name'];
            $la_area[$key] = $value;
        }
//       print_r($la_hos);
//        die();
        return $la_area;
    }
}
