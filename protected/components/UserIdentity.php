<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $command = Yii::app()->db->createCommand("SELECT * FROM {{user}} WHERE `active_status`='Y'  AND `email`='" . $_POST['LoginForm']['username'] . "' AND `password`='" . md5($_POST['LoginForm']['password']) . "' ")->queryRow();
        $users = array();
        $key = $command['email'];
        $value = $command['password'];
        $users[$key] = $value;
        $users['id'] = $command['id'];

        if (!isset($users[$this->username]))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif ($users[$this->username] !== md5($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $_SESSION['logged_user'] = $command;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

}
