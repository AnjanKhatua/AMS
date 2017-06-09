<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class GetPassword extends CFormModel {

    public $new_password;
    public $repeat_password;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('new_password, repeat_password', 'required'),
            array('new_password, repeat_password', 'safe', 'on' => 'search'),
        );
    }
}
