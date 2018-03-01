<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OjtLogs;
use App\OjtProfile;
use App\Schedule;
use App\Users;

class AdminController extends Controller
{
    public function __construct()
    { 
        $this->middleware('login');
    }

    public function admin(){ 
    	return view('admin.admin');
    }


    public function Schedule(){

    	return view('admin.schedule');
    }

    public function TraineeInfo($id){
    	$info = OjtProfile::where('ojt_profile_id',$id)->first();
    	$logs = OjtLogs::where('ojt_profile_id',$id)->orderBy('dtime_in','ASC')->get();
    	return view('admin.traineeinfo',compact('info','logs'));
    }
    public function Trainee(){
    	$ojts = OjtProfile::where('deleted',0)->get();
    	return view('admin.trainee',compact('ojts'));
    }
    public function getTrainee(Request $req){
    	$var = OjtProfile::where('ojt_profile_id',$req->id)->first();
    	return response()->json($var);
    }
    public function addTrainee(Request $req){
    	$opid = OjtProfile::insertGetId([
    		'fname' => $req->fname ,
    		'mname' => $req->mname ,
    		'lname' => $req->lname ,
    		'school' => $req->school ,
    		'render_hrs' => $req->hrs ,
    		'start_date' => date_create($req->startdate)->format('Y-m-d'),
    	]);

    	Users::insert([
    		'username' => $req->username,
    		'password' => bcrypt($req->password),
    		'ojt_profile_id' => $opid,
    	]);

    	return redirect('/Admin/Trainee');
    }
    public function editTrainee(Request $req){
    	OjtProfile::where('ojt_profile_id',$req->id)->update([
    		'fname' => $req->fname ,
    		'mname' => $req->mname ,
    		'lname' => $req->lname ,
    		'school' => $req->school ,
    		'render_hrs' => $req->hrs ,
    		'start_date' => date_create($req->startdate)->format('Y-m-d')  ,
    	]);

    	return redirect('/Admin/Trainee');
    }
    public function delTrainee(Request $req){
    	OjtProfile::where('ojt_profile_id',$req->id)->update([ 'deleted' => 1]);
    	Users::where('ojt_profile_id',$req->id)->update([ 'deleted' => 1]);
    	return redirect('/Admin/Trainee');
    }

    public function Reports(){

    	return view('admin.reports');
    }
}
