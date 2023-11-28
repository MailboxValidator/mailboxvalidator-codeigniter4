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
            return $result;
        } else {
            return array('error' => 'Email cannot be empty!');
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
            if ($result != false && (!property_exists($result, 'error')) ) {
                if (property_exists($result, 'is_free')) {
					if ($result->is_free) {
						return true;
					}
				} else {
                    return false;
                }
            } else {
				if (property_exists($result, 'error')) {
					throw new \Exception(__CLASS__ . ': ' . $result->error->error_message, $result->error->error_code);
				}
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
            if ($result != false && (!property_exists($result, 'error')) ) {
                if (property_exists($result, 'is_disposable')) {
					if ($result->is_disposable) {
						return true;
					}
				} else {
                    return false;
                }
            } else {
                // log_message('error', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message);
				if (property_exists($result, 'error')) {
					throw new \Exception(__CLASS__ . ': ' . $result->error->error_message, $result->error->error_code);
				}
                return false;
            }
        } else {
            return false;
        }
    }
}
