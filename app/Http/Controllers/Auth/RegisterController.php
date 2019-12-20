<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
     * register
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $this->validator($data)->validate();

        // Cognito側の新規登録
        $username = $this->authManager->register(
            $data['email'],
            $data['password'],
            [
                'email' => $data['email'],
            ]
        );

        // Laravel側の新規登録
        $user = $this->create($data, $username);
        event(new Registered($user));
        return redirect()->route('login')->with(['status' => 'success', 'message' => 'please check your mail!']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'cognito_user_unique'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @param $username
     * @return \App\Models\User
     */
    protected function create(array $data, $username)
    {
        return User::create([
            'cognito_username' =>  $username,
            'email' => $data['email'],
        ]);
    }
}
