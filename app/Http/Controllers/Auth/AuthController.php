<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $username = 'username';
    protected $redirectPath = '/dashboard';
    protected $loginPath = '/login';
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->loginView = $request->ajax() ? 'auth.login_ajax':'auth.login';
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
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'sduid' => 'required|numeric|digits_between:4,14|unique:users,sdu_id',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'tel' => $data['tel'],
            'position' => $data['position'],
            'email' => $data['email'],
            'sdu_id' => $data['sduid'],
            'password' => bcrypt($data['password']),
            'avatar' => sprintf('avatar_0%s.png', rand(1,8))
        ]);
    }
    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        $username = $request->input($this->loginUsername());
        
        return [
            ctype_digit($username) ? 'sdu_id':'email' => $request->input($this->loginUsername()),
            'password' => $request->input('password')
        ];
    }

    public function getCheckEmail(Request $request)
    {
        $validator = Validator::make(['email' => $request->input('email')], ['email' => 'unique:users,email',]);

        return $validator->fails() ? 'false':'true';
    }

    public function getCheckSduid(Request $request)
    {
        $validator = Validator::make(['sduid' => $request->input('sduid')], ['sduid' => 'unique:users,sdu_id',]);

        return $validator->fails() ? 'false':'true';
    }
}
