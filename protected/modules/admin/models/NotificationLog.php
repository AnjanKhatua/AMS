<?php

/**
 * This is the model class for table "{{notification_log}}".
 *
 * The followings are the available columns in table '{{notification_log}}':
 * @property string $id
 * @property string $notification_type
 * @property string $send_to
 * @property string $send_from
 * @property string $notification_sub
 * @property string $notification_body
 * @property string $send_datetime
 * @property string $ip
 */
class NotificationLog extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{notification_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('notification_type, send_to, send_from, notification_sub, notification_body, send_datetime, ip', 'required'),
            array('notification_type', 'length', 'max' => 4),
            array('send_to, send_from', 'length', 'max' => 255),
            array('ip', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, notification_type, send_to, send_from, notification_sub, notification_body, send_datetime, ip', 'safe', 'on' => 'search'),
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
            'notification_type' => 'Notification Type',
            'send_to' => 'Send To',
            'send_from' => 'Send From',
            'notification_sub' => 'Notification Sub',
            'notification_body' => 'Notification Body',
            'send_datetime' => 'Send Datetime',
            'ip' => 'Ip',
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
        $criteria->compare('notification_type', $this->notification_type, true);
        $criteria->compare('send_to', $this->send_to, true);
        $criteria->compare('send_from', $this->send_from, true);
        $criteria->compare('notification_sub', $this->notification_sub, true);
        $criteria->compare('notification_body', $this->notification_body, true);
        $criteria->compare('send_datetime', $this->send_datetime, true);
        $criteria->compare('ip', $this->ip, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NotificationLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
