<?php
namespace App\Auth;

use App\Cognito\CognitoClient;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class CognitoGuard extends SessionGuard implements StatefulGuard
{
    protected $client;
    protected $provider;
    protected $session;
    protected $request;

    /**
    * CognitoGuard constructor.
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
    */
    public function register($email, $pass, $attributes = [])
    {
        $username = $this->client->register($email, $pass, $attributes);
        return $username;
    }

    /**
    * getCognitoUser
    * Get Cognito username from email address
    */
    public function getCognitoUser($email)
    {
        return $this->client->getUser($email);
    }
}