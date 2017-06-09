<?php

/**
 * This is the model class for table "{{staff_registration}}".
 *
 * The followings are the available columns in table '{{staff_registration}}':
 * @property string $staff_id
 * @property string $start_date
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $date_of_birth
 * @property string $ni_no
 * @property string $nationality
 * @property string $passport_no
 * @property string $passport_issue_date
 * @property string $passport_expiry_date
 * @property string $visa_type
 * @property string $visa_no
 * @property string $visa_issue_date
 * @property string $visa_expiry_date
 * @property string $pay_type_id
 * @property string $company_name
 * @property string $company_no
 * @property string $date_of_incorporation
 * @property string $bank_details
 * @property string $sort_code
 * @property string $account_no
 * @property string $email
 * @property string $mobile_no
 * @property string $telephone
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $town
 * @property string $post_code
 * @property string $country
 * @property string $job_type_id
 * @property string $dbs_number
 * @property string $dbs_issue_date
 * @property string $dbs_expiry
 * @property string $mandatory_training_expiry_date
 * @property string $pmva_expiry_date
 * @property string $maybo_training_expiry
 * @property string $pin_expiry_date
 * @property integer $max_allowed_hour
 * @property string $shift_confirmation_count
 * @property string $shift_cancellation_count
 * @property string $staff_status
 *
 * The followings are the available model relations:
 * @property Booking[] $bookings
 * @property Holiday[] $holidays
 * @property ServiceCompleted[] $serviceCompleteds
 * @property StaffDocument[] $staffDocuments
 * @property PayType $payType
 * @property JobType $jobType
 * @property StaffRegistrationCompletedTrainingMapTable[] $staffRegistrationCompletedTrainingMapTables
 * @property StaffRegistrationPreferredWorkAreaMapTable[] $staffRegistrationPreferredWorkAreaMapTables
 */
class StaffRegistration extends CActiveRecord {

    public $area;
    public $areaName;
    public $pay_type;
    public $job_type;
    public $document_header_id;
    public $document_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{staff_registration}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            /*
             * @For server side validation.
             */
            array('first_name, last_name, date_of_birth, visa_expiry_date, ni_no, email, nationality, telephone, mobile_no', 'required', 'on' => 'exceptDraftArchieve', 'message' => 'Please enter {attribute}!'),
//            array('first_name, last_name, date_of_birth, visa_expiry_date, ni_no, email, nationality, telephone, mobile_no', 'required', 'on' => 'exceptDraft', 'message' => 'Please enter {attribute}!'),
//            array('first_name, last_name, ni_no, nationality, passport_no,  visa_type, visa_no, company_name, company_no, bank_details, sort_code, account_no, email, mobile_no, telephone, address_1, address_2, city, town, post_code, country, dbs_number, max_allowed_hour', 'required', 'on' => 'exceptDraft', 'message' => 'Please enter {attribute}!'),
//            array('gender, pay_type_id', 'required', 'on' => 'exceptDraft', 'message' => 'Please select {attribute}.'),
            array('gender, pay_type_id', 'required', 'on' => 'exceptDraftArchieve', 'message' => 'Please select {attribute}.'),
            array('first_name, last_name, nationality, country', 'validateAlphaWithSpaceField'),
            array('email,mobile_no', 'unique'),
            array('email', 'validateEmailField'),
            array('visa_type', 'validateAlphaHyphenWithSpaceField'),
            array('mobile_no', 'validateMobileNumber'),
            array('telephone', 'validateTelephoneNumber'),
            array('area', 'validateArea', 'on' => 'exceptDraftArchieve'),
            array('job_type', 'validateJobType', 'on' => 'exceptDraftArchieve'),
            array('visa_no, bank_details, post_code, company_no', 'validateAlphaNumericWithSpaceField'),
            array('address_1, address_2, city, town, company_name', 'validateAlphaNumericWithSpaceAndSpecialField'),
            array('ni_no, passport_no, dbs_number', 'validateAlphaNumericField'),
            array('max_allowed_hour', 'validateNumberField'),
            array('date_of_birth, visa_expiry_date', 'dateVarification', 'on' => 'exceptDraftArchieve'),
            array('start_date, date_of_birth, passport_issue_date, passport_expiry_date, visa_issue_date, visa_expiry_date, date_of_incorporation, dbs_issue_date, dbs_expiry, last_dbs_check, mandatory_training_expiry_date, pmva_expiry_date, mapa_expiry_date, maybo_training_expiry, re_validation_renewal_date, medication_assessment_completed_date, pin_expiry_date', 'dateVarificationAll'),
            /*
             * @For server side validation.
             */
            array('max_allowed_hour', 'numerical', 'integerOnly' => true),
            array('first_name, last_name', 'length', 'max' => 75),
            array('gender, sort_code', 'length', 'max' => 6),
            array('ni_no, passport_no', 'length', 'max' => 9),
            array('nationality, email, country', 'length', 'max' => 150),
            array('visa_type', 'length', 'max' => 100),
            array('visa_no', 'length', 'max' => 16),
            array('mobile_no, telephone, pin_number', 'length', 'max' => 15),
            array('pay_type_id, shift_confirmation_count, shift_cancellation_count', 'length', 'max' => 5),
            array('company_no, account_no, dbs_number', 'length', 'max' => 11),
            array('post_code', 'length', 'max' => 8),
            array('pay_type, notes, references, areaName', 'length', 'min' => 0),
            array('staff_status', 'length', 'max' => 2),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('staff_id, start_date, pin_number, first_name, last_name, gender, date_of_birth, ni_no, nationality, passport_no, passport_issue_date, passport_expiry_date, visa_type, visa_no, visa_issue_date, visa_expiry_date, pay_type_id, company_name, company_no, date_of_incorporation, bank_details, sort_code, account_no, email, mobile_no, telephone, address_1, address_2, city, town, post_code, country, dbs_number, dbs_issue_date, dbs_expiry, last_dbs_check, mandatory_training_expiry_date, pmva_expiry_date, mapa_expiry_date, maybo_training_expiry, pin_expiry_date, re-validation_renewal_date, medication_assessment_completed_date, max_allowed_hour, shift_confirmation_count, shift_cancellation_count, staff_status, references, notes, areaName', 'safe', 'on' => 'search'),
//            array('staff_id, start_date, first_name, last_name, gender, date_of_birth, ni_no, nationality, passport_no, passport_issue_date, passport_expiry_date, visa_type, visa_no, visa_issue_date, visa_expiry_date, pay_type_id, company_name, company_no, date_of_incorporation, bank_details, sort_code, account_no, email, mobile_no, telephone, address_1, address_2, city, town, post_code, country, job_type_id, dbs_number, dbs_issue_date, dbs_expiry, mandatory_training_expiry_date, pmva_expiry_date, mapa_expiry_date, maybo_training_expiry, pin_expiry_date, max_allowed_hour, shift_confirmation_count, shift_cancellation_count, staff_status, area, pay_type, job_type, document_header_id, document_name', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
//            'trainingDetail' => array(self::HAS_MANY, 'TrainingDetails', 'staff_id'),
            'bookings' => array(self::HAS_MANY, 'Booking', 'staff_id'),
            'enquirys' => array(self::HAS_MANY, 'ShiftEnquiryAck', 'staff_id'),
            'holidays' => array(self::HAS_MANY, 'Holiday', 'staff_id'),
            'serviceCompleteds' => array(self::HAS_MANY, 'ServiceCompleted', 'staff_id'),
            'staffDocuments' => array(self::HAS_MANY, 'StaffDocument', 'staff_id'),
            'payType' => array(self::BELONGS_TO, 'PayType', 'pay_type_id'),
            'staffRegistrationCompletedTrainingMapTables' => array(self::HAS_MANY, 'StaffRegistrationCompletedTrainingMapTable', 'staff_id'),
            'staffRegistrationPreferredWorkAreaMapTables' => array(self::HAS_MANY, 'StaffRegistrationPreferredWorkAreaMapTable', 'staff_id'),
        );
    }

    /*
     * @Ward validation.
     */

    public function validateArea($attribute, $params) {
        $areas = $this->$attribute;
        $count = count($areas);
        if ($count == 0) {
            $this->addError($attribute, 'Please select area!');
        }
    }

    public function validateJobType($attribute, $params) {
        $jobType = $this->$attribute;
        $count = count($jobType);
        if ($count == 0) {
            $this->addError($attribute, 'Please select job type!');
        }
    }

    public function validateAlphaWithSpaceField($attribute, $params) {
        $ls_error = Utility::validateAlphaWithSpaceField($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateAlphaHyphenWithSpaceField($attribute, $params) {
        $ls_error = Utility::validateAlphaHyphenWithSpaceField($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateMobileNumber($attribute, $params) {
        $ls_error = Utility::validateMobileNumber($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateTelephoneNumber($attribute, $params) {
        $ls_error = Utility::validateTelephoneNumber($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateAlphaNumericWithSpaceField($attribute, $params) {
        $ls_error = Utility::validateAlphaNumericWithSpaceField($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateEmailField($attribute, $params) {
        $ls_error = Utility::validateEmailField($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateAlphaNumericWithSpaceAndSpecialField($attribute, $params) {
        $ls_error = Utility::validateAlphaNumericWithSpaceAndSpecialField($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateAlphaNumericField($attribute, $params) {
        $ls_error = Utility::validateAlphaNumericField($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    public function validateNumberField($attribute, $params) {
        $ls_error = Utility::validateNumberField($this->$attribute);
        if ($ls_error) {
            $this->addError($attribute, $ls_error);
        }
    }

    /*
     * @Start date validation for server side.
     */

    public function dateVarificationAll($attribute, $params) {
        $lv_status = $this->staff_status;
        $dateBlank = '0000-00-00';
        $lv_enterDate = $this->$attribute;
//        die($lv_enterDate);
        $countStartDate = strlen($lv_enterDate);
        if ($lv_status != 'D') {
            if ($dateBlank == $lv_enterDate) {
                $this->addError($attribute, 'Please enter valid Date!');
            }
        } elseif ($countStartDate != 0 && $lv_status == 'D') {
            if ($dateBlank == $lv_enterDate) {
                $this->addError($attribute, 'Please enter valid Date!');
            }
        }
    }

    public function dateVarification($attribute, $params) {
        $lv_status = $this->staff_status;
        $dateBlank = '0000-00-00';
        $lv_enterDate = $this->$attribute;
//        die($lv_enterDate);
        $countStartDate = strlen($lv_enterDate);
        if ($lv_status != 'D') {
            if ($countStartDate == 0) {
                $this->addError($attribute, 'Please enter Date!');
            } elseif ($dateBlank == $lv_enterDate) {
                $this->addError($attribute, 'Please enter valid Date!');
            }
        } elseif ($countStartDate != 0 && $lv_status == 'D') {
            if ($dateBlank == $lv_enterDate) {
                $this->addError($attribute, 'Please enter valid Date!');
            }
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'staff_id' => 'Staff',
            'start_date' => 'Start Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'ni_no' => 'Ni No',
            'nationality' => 'Nationality',
            'passport_no' => 'Passport No',
            'passport_issue_date' => 'Passport Issue Date',
            'passport_expiry_date' => 'Passport Expiry Date',
            'visa_type' => 'Visa Type',
            'visa_no' => 'Visa No',
            'visa_issue_date' => 'Visa Issue Date',
            'visa_expiry_date' => 'Visa Expiry Date',
            'pay_type_id' => 'Pay Type',
            'company_name' => 'Company Name',
            'company_no' => 'Company No',
            'date_of_incorporation' => 'Date Of Incorporation',
            'bank_details' => 'Bank Details',
            'sort_code' => 'Sort Code',
            'account_no' => 'Account No',
            'email' => 'Email',
            'mobile_no' => 'Mobile No',
            'telephone' => 'Telephone',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'city' => 'City',
            'town' => 'Town',
            'post_code' => 'Post Code',
            'country' => 'Country',
            'areaName' => 'Preferred Work Area',
            'dbs_number' => 'Dbs Number',
            'dbs_issue_date' => 'Dbs Issue Date',
            'dbs_expiry' => 'Dbs Expiry',
            'mandatory_training_expiry_date' => 'Mandatory Training Expiry Date',
            'pmva_expiry_date' => 'PMVA Expiry Date',
            'mapa_expiry_date' => 'MAPA Expiry Date',
            'maybo_training_expiry' => 'MAYBO Training Expiry',
            'pin_expiry_date' => 'Pin Expiry Date',
            'max_allowed_hour' => 'Max Allowed Hour',
            'shift_confirmation_count' => 'Shift Confirmation Count',
            'shift_cancellation_count' => 'Shift Cancellation Count',
            'staff_status' => 'Staff Status',
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
        $criteria->with = array('payType');
        $criteria->compare('payType.pay_type', $this->pay_type, true);

        $this->staff_id = $_REQUEST['StaffRegistration']['staff_id'];
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('ni_no', $this->ni_no, true);
        $criteria->compare('nationality', $this->nationality, true);
        $criteria->compare('passport_no', $this->passport_no, true);
        $criteria->compare('passport_issue_date', $this->passport_issue_date, true);
        $criteria->compare('passport_expiry_date', $this->passport_expiry_date, true);
        $criteria->compare('visa_type', $this->visa_type, true);
        $criteria->compare('visa_no', $this->visa_no, true);
        $criteria->compare('visa_issue_date', $this->visa_issue_date, true);
        $criteria->compare('visa_expiry_date', $this->visa_expiry_date, true);
        $criteria->compare('pay_type_id', $this->pay_type_id, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_no', $this->company_no, true);
        $criteria->compare('date_of_incorporation', $this->date_of_incorporation, true);
        $criteria->compare('bank_details', $this->bank_details, true);
        $criteria->compare('sort_code', $this->sort_code, true);
        $criteria->compare('account_no', $this->account_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('mobile_no', $this->mobile_no, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('address_1', $this->address_1, true);
        $criteria->compare('address_2', $this->address_2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('town', $this->town, true);
        $criteria->compare('post_code', $this->post_code, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('dbs_number', $this->dbs_number, true);
        $criteria->compare('dbs_issue_date', $this->dbs_issue_date, true);
        $criteria->compare('dbs_expiry', $this->dbs_expiry, true);
        $criteria->compare('mandatory_training_expiry_date', $this->mandatory_training_expiry_date, true);
        $criteria->compare('pmva_expiry_date', $this->pmva_expiry_date, true);
        $criteria->compare('mapa_expiry_date', $this->mapa_expiry_date, true);
        $criteria->compare('pmva_expiry_date', $this->pmva_expiry_date, true);
        $criteria->compare('pin_expiry_date', $this->pin_expiry_date, true);
        $criteria->compare('max_allowed_hour', $this->max_allowed_hour);
        $criteria->compare('shift_confirmation_count', $this->shift_confirmation_count, true);
        $criteria->compare('shift_cancellation_count', $this->shift_cancellation_count, true);
        $criteria->compare('staff_status', $this->staff_status, true);

        if ($this->areaName)
            $criteria->addInCondition('staff_id', Utility::getStaffList($this->areaName), TRUE);

        $criteria->addInCondition('staff_status', array("A"));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "staff_id DESC")
        ));
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
    public function search_draft() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->with = array('payType');
        $criteria->compare('payType.pay_type', $this->pay_type, true);

        $this->staff_id = $_REQUEST['StaffRegistration']['staff_id'];
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('ni_no', $this->ni_no, true);
        $criteria->compare('nationality', $this->nationality, true);
        $criteria->compare('passport_no', $this->passport_no, true);
        $criteria->compare('passport_issue_date', $this->passport_issue_date, true);
        $criteria->compare('passport_expiry_date', $this->passport_expiry_date, true);
        $criteria->compare('visa_type', $this->visa_type, true);
        $criteria->compare('visa_no', $this->visa_no, true);
        $criteria->compare('visa_issue_date', $this->visa_issue_date, true);
        $criteria->compare('visa_expiry_date', $this->visa_expiry_date, true);
        $criteria->compare('pay_type_id', $this->pay_type_id, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_no', $this->company_no, true);
        $criteria->compare('date_of_incorporation', $this->date_of_incorporation, true);
        $criteria->compare('bank_details', $this->bank_details, true);
        $criteria->compare('sort_code', $this->sort_code, true);
        $criteria->compare('account_no', $this->account_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('mobile_no', $this->mobile_no, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('address_1', $this->address_1, true);
        $criteria->compare('address_2', $this->address_2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('town', $this->town, true);
        $criteria->compare('post_code', $this->post_code, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('dbs_number', $this->dbs_number, true);
        $criteria->compare('dbs_issue_date', $this->dbs_issue_date, true);
        $criteria->compare('dbs_expiry', $this->dbs_expiry, true);
        $criteria->compare('mandatory_training_expiry_date', $this->mandatory_training_expiry_date, true);
        $criteria->compare('pmva_expiry_date', $this->pmva_expiry_date, true);
        $criteria->compare('maybo_training_expiry', $this->maybo_training_expiry, true);
        $criteria->compare('mapa_expiry_date', $this->mapa_expiry_date, true);
        $criteria->compare('pin_expiry_date', $this->pin_expiry_date, true);
        $criteria->compare('max_allowed_hour', $this->max_allowed_hour);
        $criteria->compare('shift_confirmation_count', $this->shift_confirmation_count, true);
        $criteria->compare('shift_cancellation_count', $this->shift_cancellation_count, true);
        $criteria->compare('staff_status', $this->staff_status, true);

        $criteria->addInCondition('staff_status', array("D"));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "staff_id DESC")
        ));
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
    public function search_suspended() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->with = array('payType');
        $criteria->compare('payType.pay_type', $this->pay_type, true);

        $this->staff_id = $_REQUEST['StaffRegistration']['staff_id'];
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('ni_no', $this->ni_no, true);
        $criteria->compare('nationality', $this->nationality, true);
        $criteria->compare('passport_no', $this->passport_no, true);
        $criteria->compare('passport_issue_date', $this->passport_issue_date, true);
        $criteria->compare('passport_expiry_date', $this->passport_expiry_date, true);
        $criteria->compare('visa_type', $this->visa_type, true);
        $criteria->compare('visa_no', $this->visa_no, true);
        $criteria->compare('visa_issue_date', $this->visa_issue_date, true);
        $criteria->compare('visa_expiry_date', $this->visa_expiry_date, true);
        $criteria->compare('pay_type_id', $this->pay_type_id, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_no', $this->company_no, true);
        $criteria->compare('date_of_incorporation', $this->date_of_incorporation, true);
        $criteria->compare('bank_details', $this->bank_details, true);
        $criteria->compare('sort_code', $this->sort_code, true);
        $criteria->compare('account_no', $this->account_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('mobile_no', $this->mobile_no, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('address_1', $this->address_1, true);
        $criteria->compare('address_2', $this->address_2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('town', $this->town, true);
        $criteria->compare('post_code', $this->post_code, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('dbs_number', $this->dbs_number, true);
        $criteria->compare('dbs_issue_date', $this->dbs_issue_date, true);
        $criteria->compare('dbs_expiry', $this->dbs_expiry, true);
        $criteria->compare('mandatory_training_expiry_date', $this->mandatory_training_expiry_date, true);
        $criteria->compare('pmva_expiry_date', $this->pmva_expiry_date, true);
        $criteria->compare('mapa_expiry_date', $this->mapa_expiry_date, true);
        $criteria->compare('maybo_training_expiry', $this->maybo_training_expiry, true);
        $criteria->compare('pin_expiry_date', $this->pin_expiry_date, true);
        $criteria->compare('max_allowed_hour', $this->max_allowed_hour);
        $criteria->compare('shift_confirmation_count', $this->shift_confirmation_count, true);
        $criteria->compare('shift_cancellation_count', $this->shift_cancellation_count, true);
        $criteria->compare('staff_status', $this->staff_status, true);

        $criteria->addInCondition('staff_status', array("S"));


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "staff_id DESC")
        ));
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
    public function search_archive() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->with = array('payType');
        $criteria->compare('payType.pay_type', $this->pay_type, true);

        $this->staff_id = $_REQUEST['StaffRegistration']['staff_id'];
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('ni_no', $this->ni_no, true);
        $criteria->compare('nationality', $this->nationality, true);
        $criteria->compare('passport_no', $this->passport_no, true);
        $criteria->compare('passport_issue_date', $this->passport_issue_date, true);
        $criteria->compare('passport_expiry_date', $this->passport_expiry_date, true);
        $criteria->compare('visa_type', $this->visa_type, true);
        $criteria->compare('visa_no', $this->visa_no, true);
        $criteria->compare('visa_issue_date', $this->visa_issue_date, true);
        $criteria->compare('visa_expiry_date', $this->visa_expiry_date, true);
        $criteria->compare('pay_type_id', $this->pay_type_id, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_no', $this->company_no, true);
        $criteria->compare('date_of_incorporation', $this->date_of_incorporation, true);
        $criteria->compare('bank_details', $this->bank_details, true);
        $criteria->compare('sort_code', $this->sort_code, true);
        $criteria->compare('account_no', $this->account_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('mobile_no', $this->mobile_no, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('address_1', $this->address_1, true);
        $criteria->compare('address_2', $this->address_2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('town', $this->town, true);
        $criteria->compare('post_code', $this->post_code, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('dbs_number', $this->dbs_number, true);
        $criteria->compare('dbs_issue_date', $this->dbs_issue_date, true);
        $criteria->compare('dbs_expiry', $this->dbs_expiry, true);
        $criteria->compare('mandatory_training_expiry_date', $this->mandatory_training_expiry_date, true);
        $criteria->compare('pmva_expiry_date', $this->pmva_expiry_date, true);
        $criteria->compare('mapa_expiry_date', $this->mapa_expiry_date, true);
        $criteria->compare('maybo_training_expiry', $this->maybo_training_expiry, true);
        $criteria->compare('pin_expiry_date', $this->pin_expiry_date, true);
        $criteria->compare('max_allowed_hour', $this->max_allowed_hour);
        $criteria->compare('shift_confirmation_count', $this->shift_confirmation_count, true);
        $criteria->compare('shift_cancellation_count', $this->shift_cancellation_count, true);
        $criteria->compare('staff_status', $this->staff_status, true);

        $criteria->addInCondition('staff_status', array("Ar"));


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "staff_id DESC")
        ));
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
    public function search_inactive() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->with = array('payType');
        $criteria->compare('payType.pay_type', $this->pay_type, true);

        $this->staff_id = $_REQUEST['StaffRegistration']['staff_id'];
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('ni_no', $this->ni_no, true);
        $criteria->compare('nationality', $this->nationality, true);
        $criteria->compare('passport_no', $this->passport_no, true);
        $criteria->compare('passport_issue_date', $this->passport_issue_date, true);
        $criteria->compare('passport_expiry_date', $this->passport_expiry_date, true);
        $criteria->compare('visa_type', $this->visa_type, true);
        $criteria->compare('visa_no', $this->visa_no, true);
        $criteria->compare('visa_issue_date', $this->visa_issue_date, true);
        $criteria->compare('visa_expiry_date', $this->visa_expiry_date, true);
        $criteria->compare('pay_type_id', $this->pay_type_id, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_no', $this->company_no, true);
        $criteria->compare('date_of_incorporation', $this->date_of_incorporation, true);
        $criteria->compare('bank_details', $this->bank_details, true);
        $criteria->compare('sort_code', $this->sort_code, true);
        $criteria->compare('account_no', $this->account_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('mobile_no', $this->mobile_no, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('address_1', $this->address_1, true);
        $criteria->compare('address_2', $this->address_2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('town', $this->town, true);
        $criteria->compare('post_code', $this->post_code, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('dbs_number', $this->dbs_number, true);
        $criteria->compare('dbs_issue_date', $this->dbs_issue_date, true);
        $criteria->compare('dbs_expiry', $this->dbs_expiry, true);
        $criteria->compare('mandatory_training_expiry_date', $this->mandatory_training_expiry_date, true);
        $criteria->compare('pmva_expiry_date', $this->pmva_expiry_date, true);
        $criteria->compare('mapa_expiry_date', $this->mapa_expiry_date, true);
        $criteria->compare('maybo_training_expiry', $this->maybo_training_expiry, true);
        $criteria->compare('pin_expiry_date', $this->pin_expiry_date, true);
        $criteria->compare('max_allowed_hour', $this->max_allowed_hour);
        $criteria->compare('shift_confirmation_count', $this->shift_confirmation_count, true);
        $criteria->compare('shift_cancellation_count', $this->shift_cancellation_count, true);
        $criteria->compare('staff_status', $this->staff_status, true);

        $criteria->addInCondition('staff_status', array("I"));


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array("defaultOrder" => "staff_id DESC")
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StaffRegistration the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getArea($lv_vid) {
        //echo $lv_vid;die;
        $command = Yii::app()->db->createCommand("SELECT area_name FROM  {{staff_registration}}, {{staff_registration_preferred_work_area_map_table}}, {{work_area}} WHERE  {{work_area}}.work_area_id={{staff_registration_preferred_work_area_map_table}}.work_area_id AND {{staff_registration_preferred_work_area_map_table}}.staff_id={{staff_registration}}.staff_id AND {{staff_registration}}.staff_id='" . $lv_vid . "'")->queryAll();
        $area = '';
        foreach ($command as $k) {
            if ($area != '')
                $area.=', ';
            foreach ($k as $lo_user) {
                $area.=$lo_user;
            }
        }
        //die();
        return $area;
    }

    public function getJobType($lv_vid) {
        //echo $lv_vid;die;
        $command = Yii::app()->db->createCommand("SELECT job_type FROM  {{staff_registration}}, {{staff_job_type_map}}, {{job_type}} WHERE  {{job_type}}.job_type_id={{staff_job_type_map}}.job_type_id AND {{staff_job_type_map}}.staff_id={{staff_registration}}.staff_id AND {{staff_registration}}.staff_id='" . $lv_vid . "'")->queryAll();
        $job = '';
        foreach ($command as $k) {
            if ($job != '')
                $job.=', ';
            foreach ($k as $lo_user) {
                $job.=$lo_user;
            }
        }
        //die();
        return $job;
    }

    public function staffAll() {
        $command = Yii::app()->db->createCommand("SELECT SR.*,CONCAT(`first_name`,' ', `last_name`) as `full_name` FROM {{staff_registration}} SR ORDER BY full_name")->queryAll();
        $la_staff = array();
        foreach ($command as $lo_user) {
            $key = $lo_user['staff_id'];
            $la_staff[$key] = $lo_user['full_name'] . '(' . $lo_user['email'] . ')';
        }
        return $la_staff;
    }

    /*
     * Duplicate Element checking in Staff and User tables
     */

    public function checkUserEmail($ls_userEmail, $li_staffId = 0) {

        if ($li_staffId == 0) {
            $lo_modelUser = User::model()->find("email='" . $ls_userEmail . "'");
        } else {
            $lo_modelUser = User::model()->find("email='" . $ls_userEmail . "' AND staff_id!=" . $li_staffId);
        }
        if (isset($lo_modelUser->email)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function staffJobTypeWise($jobTypeId, $localAreaId, $hospitalUnitId) {
        $command = Yii::app()->db->createCommand("SELECT sr.email, u.id, u.first_name, u.last_name "
                        . "FROM {{staff_registration}} sr, {{user}} u, {{staff_job_type_map}} sjm, {{staff_registration_preferred_work_area_map_table}} srw "
                        . "WHERE sr.staff_status = 'A' AND srw.staff_id = u.staff_id AND sr.staff_id = u.staff_id AND sr.staff_id = sjm.staff_id AND srw.work_area_id = '" . $localAreaId . "' "
                        . "AND sjm.job_type_id = " . $jobTypeId . " ORDER BY u.first_name")->queryAll();
        $output = "";
        $i = 0;
//        $ld_today = date('Y-m-d H:i:s');
        foreach ($command as $lo_user) {
            $sqlQueryForStaff = "SELECT s.hospital_unit_id "
                    . "FROM {{shift_management_for_hospital}} s, {{booking}} b "
//                    . "WHERE s.staff_request_id = b.staff_request_id AND s.shift_start_datetime < '" . $ld_today . "' AND b.staff_id = '" . $lo_user['id'] . "' "
                    . "WHERE s.staff_request_id = b.staff_request_id AND b.staff_id = '" . $lo_user['id'] . "' "
                    . "AND s.hospital_unit_id = '" . $hospitalUnitId . "'";
            $commandForStaff = Yii::app()->db->createCommand($sqlQueryForStaff)->queryAll();

            if (count($commandForStaff) == 0) {
                if ($i == 0) {
                    $output .= "\t\t\t<div class='staffDiv evenStaff'  id='" . $lo_user['id'] . "'>" . $lo_user['first_name'] . " " . $lo_user['last_name'] . " (" . $lo_user['email'] . ")" . "</div>\n";
                    $i = 1;
                } elseif ($i == 1) {
                    $output .= "\t\t\t<div class='staffDiv oddStaff'  id='" . $lo_user['id'] . "'>" . $lo_user['first_name'] . " " . $lo_user['last_name'] . " (" . $lo_user['email'] . ")" . "</div>\n";
                    $i = 0;
                }
            } else {
                if ($i == 0) {
                    $output .= "\t\t\t<div class='staffDiv oldStaff'  id='" . $lo_user['id'] . "'>" . $lo_user['first_name'] . " " . $lo_user['last_name'] . " (" . $lo_user['email'] . ")" . "</div>\n";
                    $i = 1;
                } elseif ($i == 1) {
                    $output .= "\t\t\t<div class='staffDiv oldStaff'  id='" . $lo_user['id'] . "'>" . $lo_user['first_name'] . " " . $lo_user['last_name'] . " (" . $lo_user['email'] . ")" . "</div>\n";
                    $i = 0;
                }
                $la_staffWorkThisHospital[$j] = $records;
                $la_staffWorkThisHospital[$j++]['flag'] = 1;
            }
        }
        return $output;
    }

//    public function staffAllForTraining() {
//
//        $command = Yii::app()->db->createCommand("SELECT * FROM {{staff_registration}} WHERE `staff_status`='A' ORDER BY `first_name`")->queryAll();
//        $la_training = array('' => "Select One");
//        foreach ($command as $lo_training) {
//            $key = $lo_training['staff_id'];
//            $value = $lo_training['first_name'] . " " . $lo_training['last_name'] . " (" . $lo_training['email'] . ")";
//            $la_training[$key] = $value;
//        }
//        return $la_training;
//    }
}
