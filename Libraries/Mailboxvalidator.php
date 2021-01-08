<?php namespace App\Libraries;

require_once('MailboxValidator/EmailValidation.php');

class Mailboxvalidator {
    protected $mbv;
    
    public function __construct($params) {
        $key = $params['mbv_api_key'];
        $this->mbv = new \MailboxValidator\EmailValidation($key);
    }

    public function getSingleResult($email) {
        if ($email != ''){
            $result = $this->mbv->validateEmail($email);
        }
    }

    /*
    public function isValidEmail($email) {
        if ($email != ''){
            return $this->mbv->validateEmail($email);
            if ($result != false && $result->error_code == '') {
                if ($result->status == 'True') {
                    return true;
                } else {
                    return false;
                }
            } else {
                // log_message('error', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message);
                return false;
            }
        } else {
            return false;
        }
    }*/
    
    public function isFreeEmail($email) {
        if ($email != ''){
            $result = $this->mbv->isFreeEmail($email);
            if ($result != false && $result->error_code == '') {
                if ($result->is_free == 'True') {
                    return true;
                } else {
                    return false;
                }
            } else {
                // log_message('error', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message);
                return false;
            }
        } else {
            return false;
        }
    }

    public function isDisposableEmail($email) {
        if ($email != ''){
            $result = $this->mbv->isDisposableEmail($email);
            if ($result != false && $result->error_code == '') {
                if ($result->is_disposable == 'True') {
                    return true;
                } else {
                    return false;
                }
            } else {
                // log_message('error', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message);
                return false;
            }
        } else {
            return false;
        }
    }
}
