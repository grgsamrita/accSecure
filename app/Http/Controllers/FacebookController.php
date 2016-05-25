<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class FacebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFblogin()
    {
         return \Socialite::driver('facebook')->redirect();
    }

    public function getFbcallback(){
       

        try {
            $user = \Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('facebook/fblogin');
        }

        $authUser = $this->findOrCreateUser($user);

        \Auth::login($authUser, true);

        return redirect()->route('accountdata');
    } 


    private function findOrCreateUser($facebookUser) {
        $authUser = User::where('facebook_id', $facebookUser->id)->where('email', '!=', $facebookUser->user['email'])->first();

        if ($authUser) {
            return $authUser;
        }

        return User::create([
                    'name' => $facebookUser->user['name'],
                    'username' => $facebookUser->user['username'],
                    'email' => $facebookUser->user['email'],
                    'facebook_id' => $facebookUser->id,
        ]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
