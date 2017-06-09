<?php

/**
 * This is the model class for table "{{pay_type}}".
 *
 * The followings are the available columns in table '{{pay_type}}':
 * @property string $pay_type_id
 * @property string $pay_type
 * @property string $pay_type_active_status
 *
 * The followings are the available model relations:
 * @property StaffRegistration[] $staffRegistrations
 */
class PayType extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{pay_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pay_type', 'required'),
            array('pay_type', 'length', 'max' => 100),
            array('pay_type_active_status', 'length', 'max' => 1),
            array('pay_type', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('pay_type_id, pay_type, pay_type_active_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'staffRegistrations' => array(self::HAS_MANY, 'StaffRegistration', 'pay_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pay_type_id' => 'Pay Type',
            'pay_type' => 'Pay Type',
            'pay_type_active_status' => 'Pay Type Active Status',
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

        $criteria->compare('pay_type_id', $this->pay_type_id, true);
        $criteria->compare('pay_type', $this->pay_type, true);
        $criteria->compare('pay_type_active_status', $this->pay_type_active_status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "pay_type_id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PayType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function payTypeAll() {

        $command = Yii::app()->db->createCommand("SELECT * FROM {{pay_type}} WHERE `pay_type_active_status`='Y'")->queryAll();
        $la_area = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['pay_type_id'];
            $value = $lo_user['pay_type'];
            $la_area[$key] = $value;
        }
        //       print_r($la_hos);
        //        die();
        return $la_area;
    }

}
