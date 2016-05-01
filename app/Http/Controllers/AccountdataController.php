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
use validator;


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
    public function postAdd(Request $request, Data $accdata)
    {
        $accountdata = $request->all();
        $user = \Auth::user();
        $validator = \Validator::make($request->all(), [
            'account' => 'required|email',
            'account_name' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
         if ($validator->fails())
        {
            return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        }   

        $accountdata =array(     
            'user_id' => $user->id,
            'account' => $request->input('account'),
            'account_name' => $request->input('account_name'),
            'username' => $request->input('username'),
            'password' => \Crypt::encrypt($request->input('password')), //bcrypt($request->input('password')),
            );  

        $data = Data::where('account','=',$request->input('account'))->get(); 
        if(!count($data)){
            $accdata->insert($accountdata);
                    return 'done';
        }
        else{
            foreach($data as $eachdata){
                if($eachdata->account_name == $request->input('account_name')){
                    return ['warning'=>'matches', 'msg'=>'This '.$request->input('account').' for '.$request->input('account_name').' already exists. Please enter another account for this account name.'];
                    
                }                
                    $accdata->insert($accountdata);
                    return 'done';
               
            
            }  
        }       
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

    public function getUpdate($id){
        $data = Data::findOrFail($id);
        return response(['msg' => 'done', 'username'=>$data->username]);
    }

     public function postUpdate(Request $request, Data $accdata)
    {
        $accountdata = $request->all();
        $user = \Auth::user();
        $validator = \Validator::make($request->all(), [
            'username' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
            'remember_password' => 'required'
        ]);
         if ($validator->fails())
        {
            return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        }   
        $accountdata = $accdata->find($request->input('id'));
        if($accountdata){
            // return $accountdata;
            
            if($request->input('old_password') != \Crypt::decrypt($accountdata->password) ){
                
                return ['warning'=>'not_match','message'=>'The password you entered does not match with your old password. Please retype the correct password']; 
            }
            if($request->input('new_password')!= $request->input('remember_password')) {
                return ['warning'=>'incorrect','message'=>'The remember password does not match with your new password'];
            }
            
            $accountdata->username = $request->input('username');
            $accountdata->password = \Crypt::encrypt($request->input('new_password'));
            $accountdata->save();
            
        }
        
        
        return ['msg'=>'done','username'=>$request->input('username')];            
        
    }

    //delete account data from view datas
    public function getDestroy($id)
    {
        
        $account = Data::findOrFail($id);
        $account->delete();

        return response(['msg' => 'Account deleted', 'status' => 'success']);
        

        // return 'success';
        
        
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
