<?php

/**
 * This is the model class for table "{{document_header}}".
 *
 * The followings are the available columns in table '{{document_header}}':
 * @property string $document_header_id
 * @property string $header_name
 * @property string $active_status
 *
 * The followings are the available model relations:
 * @property StaffDocument[] $staffDocuments
 */
class DocumentHeader extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{document_header}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('header_name', 'required'),
			array('header_name', 'length', 'max'=>255),
			array('active_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('document_header_id, header_name, active_status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'staffDocuments' => array(self::HAS_MANY, 'StaffDocument', 'document_header_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'document_header_id' => 'Document Header',
			'header_name' => 'Header Name',
			'active_status' => 'Active Status',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('document_header_id',$this->document_header_id,true);
		$criteria->compare('header_name',$this->header_name,true);
		$criteria->compare('active_status',$this->active_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    	'sort'=>array("defaultOrder"=>"document_header_id DESC")
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentHeader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
                        public function docTypeAll() {
                                    $command = Yii::app()->db->createCommand("SELECT * FROM {{document_header}} WHERE `active_status`='Y'")->queryAll();
                                    $la_doc = array();
                                    foreach ($command as $lo_user) {
                                        $key = $lo_user['document_header_id'];
                                        $value = $lo_user['header_name'];
                                        $la_doc[$key] = $value;
                                    }
                            //       print_r($la_doc);
                            //        die();
                                    return $la_doc;
                                }
}
