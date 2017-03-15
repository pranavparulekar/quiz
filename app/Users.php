<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    public static function is_valid($input){
    	$result = DB::table('users')
    	->select('user_id','quiz_attempt','username')
    	->where('username',$input['username'])
    	->where('password',$input['password'])
    	->get();

    	if($result->count()){
            DB::table('users')
            ->where('username',$input['username'])
            ->where('password',$input['password'])
            ->increment('quiz_attempt');

    		return $result;
    	}else{
    		return false;
    	}
    }

}
