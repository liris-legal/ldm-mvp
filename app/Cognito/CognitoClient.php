<?php

namespace App\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;

class CognitoClient
{
    const RESET_REQUIRED         = 'PasswordResetRequiredException';
    const USER_NOT_FOUND         = 'UserNotFoundException';
    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $poolId;

    /**
     * CognitoClient constructor
     * @param CognitoIdentityProviderClient $client
     * @param $clientId
     * @param $clientSecret
     * @param $poolId
     */
    public function __construct(
        CognitoIdentityProviderClient $client,
        $clientId,
        $clientSecret,
        $poolId
    ) {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->poolId = $poolId;
    }

    /**
     * register
     * @param $email
     * @param $password
     * @param array $attributes
     * @return mixed
     */
    public function register($email, $password, $attributes = [])
    {
        try {
            $response = $this->client->signUp([
                'ClientId' => $this->clientId,
                'Password' => $password,
                'SecretHash' => $this->cognitoSecretHash($email),
                'UserAttributes' => $this->formatAttributes($attributes),
                'Username' => $email
            ]);
        } catch (CognitoIdentityProviderException $e) {
            throw $e;
        }
        return $response['UserSub'];
    }

    /**
     * cognitoSecretHash
     * @param $username
     * @return string
     */
    protected function cognitoSecretHash($username)
    {
        return $this->hash($username . $this->clientId);
    }

    /**
     * hash
     * @param $message
     * @return string
     */
    protected function hash($message)
    {
        $hash = hash_hmac(
            'sha256',
            $message,
            $this->clientSecret,
            true
        );
        return base64_encode($hash);
    }

    /**
     * formatAttributes
     * attributesを保存用に整形
     * @param array $attributes
     * @return array
     */
    protected function formatAttributes(array $attributes)
    {
        $userAttributes = [];
        foreach ($attributes as $key => $value) {
            $userAttributes[] = [
                'Name' => $key,
                'Value' => $value,
            ];
        }
        return $userAttributes;
    }

    /**
     * getUser
     * メールアドレスからユーザー情報を取得する
     * @param $username
     * @return \Aws\Result|bool
     */
    public function getUser($username)
    {
        try {
            $user = $this->client->adminGetUser([
                'Username' => $username,
                'UserPoolId' => $this->poolId,
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return false;
        }
        return $user;
    }

    /**
     * Authenticate
     * @param $email
     * @param $password
     * @return bool
     */
    public function authenticate($email, $password)
    {
        try {
            $this->client->adminInitiateAuth([
                'AuthFlow' => 'ADMIN_USER_PASSWORD_AUTH',
                'AuthParameters' => [
                    'USERNAME' => $email,
                    'PASSWORD' => $password,
                    'SECRET_HASH' => $this->cognitoSecretHash($email)
                ],
                'ClientId' => $this->clientId,
                'UserPoolId' => $this->poolId
            ]);
        } catch (CognitoIdentityProviderException $exception) {
            if ($exception->getAwsErrorCode() === self::RESET_REQUIRED ||
                $exception->getAwsErrorCode() === self::USER_NOT_FOUND) {
                return false;
            }

            throw $exception;
        }
        return true;
    }
}
