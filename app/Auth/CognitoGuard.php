<?php

namespace App\Auth;

use App\Cognito\CognitoClient;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Request;

class CognitoGuard extends SessionGuard implements StatefulGuard
{
    protected $client;
    protected $provider;
    protected $session;
    protected $request;

    /**
     * CognitoGuard constructor.
     * @param $name
     * @param $client
     * @param $provider
     * @param $session
     * @param $request
     */
    public function __construct(
        string $name,
        CognitoClient $client,
        UserProvider $provider,
        Session $session,
        ?Request $request = null
    ) {
        $this->client = $client;
        $this->provider = $provider;
        $this->session = $session;
        $this->request = $request;
        parent::__construct($name, $provider, $session, $request);
    }

    /**
     * register
     * Register new users
     * @param $email
     * @param $pass
     * @param $attributes
     * @return string
     */
    public function register($email, $pass, $attributes = [])
    {
        return $this->client->register($email, $pass, $attributes);
    }

    /**
     * getCognitoUser
     * Get Cognito username from email address
     * @param $email
     * @return string
     */
    public function getCognitoUser($email)
    {
        return $this->client->getUser($email);
    }

    /**
     * HasValidCredentials
     * @param $user
     * @param $credentials
     * @return bool
     */
    protected function hasValidCredentials($user, $credentials)
    {
        $result = $this->client->authenticate($credentials['email'], $credentials['password']);
        if ($result && $user instanceof Authenticatable) {
            return true;
        }
        return false;
    }

    /**
     * attempt
     * @param array $credentials
     * @param boolean $remember
     * @return boolean
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        $this->fireAttemptEvent($credentials, $remember);
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);
        if ($this->HasValidCredentials($user, $credentials)) {
            $this->login($user, $credentials);
            return true;
        }
        $this->fireFailedEvent($user, $credentials);
        return false;
    }
}
