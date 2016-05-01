<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

     public function getRegister(){
        return view('auth/register');
    }

    public function postRegister(Request $request, User $user){
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

       $data = array(

              'name' => $request->input('name'),
              'email' => $request->input('email'),
              'username' => $request->input('username'),
              'password' => bcrypt($request->input('password')),

          );
       
       $user->insert($data);
       return redirect()->to('accountdata/account')->with('name',$user['name']);
    }
}
