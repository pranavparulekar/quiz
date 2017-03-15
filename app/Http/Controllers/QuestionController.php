<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class QuestionController extends Controller
{
    public function show(Request $request){

    	$max_que = $request->session()->get('max_que');

    	$qArr = $request->session()->get('questions');

    	//print_r($qArr);exit;

    	return view('question',[
    		'data' => $qArr, 
    		'max_que' => $max_que, 
    		'username' => $request->session()->get('username'),
    		'attempt' => $request->session()->get('attempt')]
    		);
    }

    public function show_result(Request $request){

    	$input = $request->all();
    	$max_que = $request->session()->get('max_que');
    	$qArr = $request->session()->get('questions');
    	$attempt = $request->session()->get('attempt');
    	$user_id = $request->session()->get('user_id');
    	$username = $request->session()->get('username');


    	$total_score = 0;

    	$insertArr = array();

    	for($i=1;$i<=$max_que;$i++){
    		
    		$qid = $qArr[$i]['qid'];
    		$user_answer = $input['opt_'.$i];
    		$score = $qArr[$i]['options'][$user_answer]['score'];

    		$insertArr[] = array('user_id'=>$user_id, 'attempt' => $attempt, 'question_id' => $qid, 'user_answer' => $user_answer, 'score' => $score);

    		$total_score += $score;
    	}



    	DB::table('user_score')->insert($insertArr);

    	$request->session()->flush();

    	return view('score',[
    		'username' => $username, 
    		'score' => $total_score,
    		'attempt' => $attempt
    		]);
    }
}
