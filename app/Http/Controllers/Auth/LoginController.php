<?php

namespace App\Http\Controllers\Auth;

use App\Cognito\CognitoClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * $authManager instance
     *
     */
    protected $authManager;

    /**
     * Create a new controller instance.
     *
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->middleware('guest')->except('logout');

        $this->authManager = $authManager;
    }

    /**
     * sendFailedCognitoResponse
     * @param $exception
     * @throws ValidationException
     */
    private function sendFailedCognitoResponse(CognitoIdentityProviderException $exception)
    {
        throw ValidationException::withMessages([
            $this->username() => $exception->getAwsErrorMessage(),
        ]);
    }

    /**
     * Login user
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        try {
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        } catch (CognitoIdentityProviderException $ce) {
            return $this->sendFailedCognitoResponse($ce);
        } catch (\Exception $e) {
            return $this->sendFailedLoginResponse($request);
        }
        return $this->sendFailedLoginResponse($request);
    }
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $message = ['status' => 'success', 'content' => 'ログアウトしました。'];

        return $this->loggedOut($request) ?:
            response()->json(['url' => route('login'), 'message' => $message], 200);
    }
}
