<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OjtLogs;
use App\OjtProfile;
use App\Schedule;
use App\Users;
use PDF;

class AdminController extends Controller
{
    public function __construct()
    { 
        $this->middleware('login');
    }

    public function admin(){ 
    	// return view('admin.admin');
        return redirect('/Admin/Trainee');
    }


    public function Schedule(){
        $scheds = Schedule::where('deleted',0)->get();
    	return view('admin.schedule',compact('scheds'));
    }
    public function getSchedule(Request $req){
        $var = Schedule::where('schedule_id',$req->id)->first();
        return response()->json($var);
    }
    public function addSchedule(Request $req){
        Schedule::insert([
            'starttime' => date_create($req->starttime)->format('H:i:s'),
            'endtime' => date_create($req->endtime)->format('H:i:s')
        ]);
        return redirect('/Admin/Schedule');
    }
    public function editSchedule(Request $req){
        Schedule::where('schedule_id',$req->id)->update([
            'starttime' => date_create($req->starttime)->format('H:i:s'),
            'endtime' => date_create($req->endtime)->format('H:i:s')
        ]);
        return redirect('/Admin/Schedule');
    }
    public function delSchedule(Request $req){
        Schedule::where('schedule_id',$req->id)->update([ 'deleted' => 1 ]);
        return redirect('/Admin/Schedule');
    }


    public function TraineeInfo($id){
    	$info = OjtProfile::where('ojt_profile_id',$id)->first();
    	$logs = OjtLogs::where('ojt_profile_id',$id)->orderBy('dtime_in','ASC')->get();

    	return view('admin.traineeinfo',compact('info','logs'));
    }
    public function TraineePdf(Request $req){
        if($req->has('download')){
	    	$info = OjtProfile::where('ojt_profile_id',$req->id)->first();
	    	$logs = OjtLogs::where('ojt_profile_id',$req->id)->orderBy('dtime_in','ASC')->get();
        	$pdf = PDF::loadView('pdfview',compact('info','logs'));
			return $pdf->stream('Trainee Info.pdf');
        }
        return redirect('/Admin/Trainee/'.$req->id);
    }
    public function Trainee(){
        $scheds = Schedule::where('deleted',0)->get();
    	$ojts = OjtProfile::where('deleted',0)->orderBy('ojt_profile_id','DESC')->get();
    	return view('admin.trainee',compact('ojts','scheds'));
    }
    public function getTrainee(Request $req){
        $var = OjtProfile::where('ojt_profile_id',$req->id)->first();
        return response()->json($var);
    }
    public function checkUsername(Request $req){
        $var = Users::where('username',$req->value)->get();
        return response()->json($var);
    }
    public function addLog(Request $req){
    	echo $log = OjtLogs::whereDate('dtime_in',date_create($req->in)->format('Y-m-d'))->first();
    	if ($log == "") {
	    	OjtLogs::insert([
	    		'ojt_profile_id' => $req->id,
	    		'dtime_in' => date_create($req->in)->format('Y-m-d H:i:s'),
	    		'dtime_out' => date_create($req->out)->format('Y-m-d H:i:s')
	    	]);
	    	return redirect('/Admin/Trainee/'.$req->id);
    	} else { 
	    	return redirect('/Admin/Trainee/'.$req->id)->with('message','Duplicate Date.');
    	}
    }
    public function delLog(Request $req){
    	echo OjtLogs::where('ojt_profile_id',$req->id)->whereDate('dtime_in',date_create($req->date)->format('Y-m-d'))->whereTime('dtime_in','Like','%'.date_create($req->date)->format('H:i').'%')->delete(); 
    	return redirect('/Admin/Trainee/'.$req->id);
    }
    public function addTrainee(Request $req){
    	$opid = OjtProfile::insertGetId([
    		'fname' => $req->fname ,
    		'mname' => $req->mname ,
            'lname' => $req->lname ,
    		'schedule_id' => $req->schedule ,
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
    		'schedule_id' => $req->schedule ,
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

   	public function pdfview(Request $request)
    {
        // $users = 'DB::table("users")->get()';
        // view()->share('users',$users);

        if($request->has('download')){
        	// Set extra option
        	// PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        	// // pass view file
         //    return $pdf = PDF::loadView('pdfview');
         //    // download pdf
         //    return $pdf->download('pdfview.pdf');
        	$pdf = PDF::loadView('pdfview');
			return $pdf->stream('invoice.pdf');
        }
        return view('pdfview');
    }
}
