<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Users;
use Session;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function view_login(){
    	return view('login');
    }

    public function do_validation(Request $request){
    	$input = $request->all();

    	$validator = Validator::make($input,[
    		'username' => 'required',
    		'password' => 'required'
    	],[
    		'username.required'      => 'Username is required',
    		'password.required'      => 'Password is required'
    	]);

    	if($validator->fails()){
    		return redirect('login')
                        ->withErrors($validator);
    	}else{
    		if($res = Users::is_valid($input)){

                $row = $res->first();
                $request->session()->put('user_id',$row->user_id);
                $request->session()->put('attempt',$row->quiz_attempt+1); 
                $request->session()->put('username',$row->username); 



                $questions = DB::table('questions')->get()->toArray();
                $options = DB::table('options')->get()->toArray();

                foreach($options as $row){
                    $oArr[$row->qid][$row->oid] = array('option_text' => $row->option_text, 'score' => $row->score);
                }

                $i=0;

                foreach ($questions as $row) {
                    $qArr[++$i] = array('qid' => $row->qid, 'question' => $row->question, 'options' => $oArr[$row->qid]);
                }

                $request->session()->put('questions',$qArr);
                $request->session()->put('max_que',count($qArr));

                return redirect('question');
    		}else{
    			return redirect('login')->with('status', 'Invalid username or password');
    		}
    	}

    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('login');
    }

    public function get_score($user_id=''){

        if( empty($user_id) || !preg_match('/^\d+$/',$user_id) ){
            exit('User ID should be valid number');
        }


        $result = DB::table('user_score')
        ->where('user_id',$user_id)
        ->groupBy('attempt')
        ->select('attempt', DB::raw('SUM(score) as total_score'))
        ->get();

        if($result->count()){
            foreach($result as $row){
                $arr[] = (array) $row;
            }
        
            echo json_encode($arr);
        }else{
            echo "No record found";
        }

        
    }

    
}
