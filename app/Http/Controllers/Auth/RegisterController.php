<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Illuminate\Foundation\Auth\RegistersUsers;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    const INVALID_PASSWORD         = 'InvalidPasswordException';

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * AuthManager instance
     *
     * @var Object
     */
    protected $authManager;

    /**
     * Create a new controller instance.
     *
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->middleware('guest');
        $this->authManager = $authManager;
    }

    /**
     * Register
     * @param Request $request
     * @return RedirectResponse|string
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $this->validator($data)->validate();

        try {
            // Cognito側の新規登録
            $username = $this->authManager->register(
                $data['email'],
                $data['password'],
                [
                    'email' => $data['email'],
                ]
            );
        } catch (CognitoIdentityProviderException $exception) {
            if ($exception->getAwsErrorCode() === self::INVALID_PASSWORD) {
                dd($exception);
                return $exception->getAwsErrorMessage();
            }

            throw $exception;
        }

        // Laravel側の新規登録
        $user = $this->create($data, $username);
        event(new Registered($user));
        return redirect()->route('login')->with(['status' => 'success', 'message' => 'please check your mail!']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'email', 'max:255', 'unique:users', 'cognito_user_unique'],
            'password' => ['required', 'string', 'min:8', 'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,35}.+$/i'],
            'password_confirmation' => 'required|min:8|max:32'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @param $username
     * @return User
     */
    protected function create(array $data, $username)
    {
        return User::create([
            'cognito_username' => $username,
            'email' => $data['email'],
        ]);
    }
}
