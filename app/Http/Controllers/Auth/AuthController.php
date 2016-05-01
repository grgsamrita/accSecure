<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\RegRequest;
use Redirect;
use Session;

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

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

     public function getIndex(){
        return view('auth/login');
    }

     public function getRegister(){
        return view('auth/register');
    }

    public function postRegister(RegRequest $request, User $user){
        $data = $request->all();
        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        );
       
       $user->insert($data);
       if(\Auth::attempt($request->only('username', 'password'))){
            return redirect('accountdata/account');
       }
    }

    public function postLogin(Request $request, User $user){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $field = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('username')]);

        if (\Auth::attempt($request->only($field, 'password')))
        {
            return redirect()->to('accountdata/account');
        }

        return redirect('/')
                    ->withInput($request->only('username', 'password'))
                    ->withErrors([
                        'error' => $this->getFailedLoginMessage(),
                        
                    ]);
    }


    public function getLogout(){
        \Auth::logout();
        return Redirect::guest('/');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => 'required|max:255',
    //         'email' => 'required|email|max:255|unique:users',
    //         'password' => 'required|confirmed|min:6',
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => bcrypt($data['password']),
    //     ]);
    // }

   
}
