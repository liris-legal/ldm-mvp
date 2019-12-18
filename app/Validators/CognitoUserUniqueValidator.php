<?php
namespace App\Validators;

use Illuminate\Auth\AuthManager;

class CognitoUserUniqueValidator
{
    /**
     * @var $authManager
     */
//    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->AuthManager = $authManager;
    }

    public function validate($attribute, $value, $parameters, $validator)
    {
        $cognitoUser = $this->AuthManager->getCognitoUser($value);
        if ($cognitoUser) {
            return false;
        }
        return true;
    }
}
