<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AccountRequest;
use App\Http\Controllers\Controller;
use App\Data;
use Hash;
use Input;
use Crypt;


class AccountdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccount()
    {
        $user = \Auth::user();
        $accdata = Data::where('user_id','=',$user->id)->get();
        
        return view('accountdata')->with(['accountdata'=>$accdata, 'user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postAdd(AccountRequest $request, Data $accdata)
    {
        $accountdata = $request->all();
        $user = \Auth::user();
        $accountdata =array(     
            'user_id' => $user->id,
            'account' => $request->input('account'),
            'username' => $request->input('username'),
            'password' => \Crypt::encrypt($request->input('password')), //bcrypt($request->input('password')),
            );      

        $accdata->insert($accountdata);      
        return 'done';
        
    }

    public function getViewpswd(Request $request, $id, $password){
       // return $id;
        $user = \Auth::user();
        // return $password;
        
        if (Hash::check($password, $user->password))
        {
            $data = Data::findOrFail($id);
            $decrypt = \Crypt::decrypt($data->password); 
            // return $decrypt;
            return response(['msg' => 'done', 'account' => $data->account, 'pass' => $decrypt]);
        }
        return 'error';


    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
