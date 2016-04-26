<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'datas';
    protected $fillable = ['user_id', 'account', 'username', 'password'];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
