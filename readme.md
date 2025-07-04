# MailboxValidator CodeIgniter 4 Email Validation Package

MailboxValidator CodeIgniter 4 Email Validation Package enables user to easily validate if an email address is valid, a type of disposable email or free email.

This package can be useful in many types of projects, for example

 - to validate an user's email during sign up
 - to clean your mailing list prior to email sending
 - to perform fraud check
 - and so on



## Installation

Upload the ``Libraries`` folder to your CodeIgniter ``app`` folder



## Dependencies

This package will only work with CodeIgniter 4. For CodeIgniter 3, you can get it from [here](https://github.com/MailboxValidator/mailboxvalidator-codeigniter).

An API key is required for this module to function.

Go to https://www.mailboxvalidator.com/plans#api to sign up for FREE API plan and you'll be given an API key.

After you get your API key, you can set you API key in controller during calling library. For example:
```php
use App\Libraries\Mailboxvalidator;
$params = array('mbv_api_key' => 'PASTE_YOUR_API_KEY_HERE');
$mbv = new Mailboxvalidator($params);
```



## Functions

### getSingleResult (email_address)

Performs email validation on the supplied email address.

#### Return Fields

| Field Name | Description |
|-----------|------------|
| email_address | The input email address. |
| domain | The domain of the email address. |
| is_free | Whether the email address is from a free email provider like Gmail or Hotmail. Return values: True, False |
| is_syntax | Whether the email address is syntactically correct. Return values: True, False |
| is_domain | Whether the email address has a valid MX record in its DNS entries. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_smtp | Whether the mail servers specified in the MX records are responding to connections. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_verified | Whether the mail server confirms that the email address actually exist. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_server_down | Whether the mail server is currently down or unresponsive. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_greylisted | Whether the mail server employs greylisting where an email has to be sent a second time at a later time. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_disposable | Whether the email address is a temporary one from a disposable email provider. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_suppressed | Whether the email address is in our blacklist. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_role | Whether the email address is a role-based email address like admin@example.net or webmaster@example.net. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_high_risk | Whether the email address contains high risk keywords. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_catchall | Whether the email address is a catch-all address. Return values: True, False, Unknown, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| mailboxvalidator_score | Email address reputation score. Score > 0.70 means good; score > 0.40 means fair; score <= 0.40 means poor. |
| time_taken | The time taken to get the results in seconds. |
| status | Whether our system think the email address is valid based on all the previous fields. Return values: True, False |
| credits_available | The number of credits left to perform validations. |
| error_code | The error code if there is any error. See error table in the below section. |
| error_message | The error message if there is any error. See error table in the below section. |



#### isDisposableEmail (email_address)

Check whether the email address is belongs to a disposable email provider or not. Return Values: True, False



#### isFreeEmail (email_address)

Check whether the email address is belongs to a free email provider or not. Return Values: True, False



## Usage

### Form Validation

To use this library in form validation, first create a new file under ``app/Libraries`` called ``FormValidation.php``.

After that, copy the following sample code into ``FormValidation.php``:
```php
<?php namespace App\Libraries;

use App\Libraries\Mailboxvalidator;

class FormValidation
{
    public function disposable($email, string &$error = null): bool
    {
        $params = array('mbv_api_key' => 'PASTE_YOUR_API_KEY_HERE');
        $$mbv = new Mailboxvalidator($params);
        if ($$mbv->isDisposableEmail($email) === true) {
            // If is_email_disposable return true, means the email is disposable email
            $error = 'A disposable email address is detected.';
            return false;
        } else {
            return true;
        }
    }

    public function free($email, string &$error = null): bool
    {
        $params = array('mbv_api_key' => 'PASTE_YOUR_API_KEY_HERE');
        $$mbv = new Mailboxvalidator($params);
        if ($$mbv->isFreeEmail($email) === true) {
            // If is_email_free return true, means the email is free email
            $error = 'A free email address is detected.';
            return false;
        } else {
            return true;
        }
    }
}
```

After that, open your ``app\Config\Validation.php`` file, and add the below line into the ``$ruleSets`` array:

```php
        \App\Libraries\FormValidation::class,
```



Next, in your form controller, you can use the function from ``FormValidation.php`` to validate email. For example, if you want to use the ``disposable`` function to validate email, you can follow sample code as shown in below:

```php
<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Form extends Controller
{
    public function index()
    {
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        echo view('Signup');
    }
    public function submit()
    {
        helper(['form', 'url']);

        if (! $this->validate([
            'username' => 'required',
            'email' => 'disposable',
        ]))
        {
            echo view('Signup-error', [
                'validation' => $this->validator
            ]);
        }
        else
        {
            echo view('Success');
        }
    }
}
```

Noted that you will be required to add a custom error message for it. Now you can open your form and try to enter a disposable email address to see the outcome. The form should return the error message for the disposable email.

### Email Validation

To use this library to get validation result for an email address, firstly load the library in your controller like this:
```php
use App\Libraries\Mailboxvalidator;
```
Next, in your controller function, load your MailboxValidator API key like this:

```php
$params = array('mbv_api_key' => 'PASTE_YOUR_API_KEY_HERE');
$mbv = new Mailboxvalidator($params);
```

After that, you can get the validation result for the email address like this:

```php
$result = $mbv->getSingleResult('test@example.com');
```
To pass the result to the view, just simply add the $result to your view loader like this:
```php
echo view('result', $result);
```
And then in your view file, call the validation results. For example:
```php
<?= esc($email_address) ?>
<?= esc($mailboxvalidator_score) ?>
<?= boolval($status) ? 'Yes' : 'No' ?>
```
You can refer the full list of response parameters at above table.


## Errors

| error_code | error_message         |
| ---------- | --------------------- |
| 10000        | Missing parameter.    |
| 10001        | API key not found.    |
| 10002        | API key disabled.     |
| 10003        | API key expired.      |
| 10004        | Insufficient credits. |
| 10005        | Unknown error.        |



## Copyright

Copyright (C) 2024 by MailboxValidator.com, support@mailboxvalidator.com
