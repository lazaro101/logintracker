<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Users;
use App\OjtLogs;

class UserController extends Controller
{
    public function login(){ 
    	return view('login');
    }
    public function showAdminLogin(){
        return view('adminlogin');
    }

    public function doLogin(Request $req){
        if(Auth::attempt(['username'=> $req->username,'password'=> $req->password, 'usertype' => 0, 'deleted' => 0])){
            if ($req->submit == 'login') {   
                $log = OjtLogs::where('ojt_profile_id',Auth::user()->ojt_profile_id)->orderBy('dtime_in','DESC');
                $datelog = date_create($log->first()->dtime_in)->format('M d, Y - h:i a');
                if ($log->first() == "" || $log->first()->dtime_out != null) {
                    OjtLogs::insert([
                        'ojt_profile_id' => Auth::user()->ojt_profile_id,
                        'dtime_in' => date_create('now')->format('Y-m-d H:i:s')
                    ]);
                    $datelog = date_create($log->first()->dtime_in)->format('M d, Y - h:i a');
                    Auth::logout(); 
                    return redirect('/')->with('message','Logged in : '.$datelog)->with('type','success');
                }
                Auth::logout(); 
                return redirect('/')->with('message','Logged in : '.$datelog)->with('type','info');
            } else {
                $log = OjtLogs::where('ojt_profile_id',Auth::user()->ojt_profile_id)->orderBy('dtime_in','DESC')->limit(1);
                $datelog = date_create($log->first()->dtime_in)->format('M d, Y - h:i a');
                if ($log->first()->dtime_out == null) {
                    $log->update([ 'dtime_out' => date_create('now')->format('Y-m-d H:i:s')]);
                    Auth::logout(); 
                    return redirect('/')->with('message','Logged out : '.$datelog)->with('type','success');
                }
                Auth::logout(); 
                return redirect('/')->with('message','Logged out : '.$datelog)->with('type','info');
            }
             
        }
        return redirect('/')->with('message','No matching Login!')->with('type','error');
    }
    public function doLoginAdmin(Request $req){
        if(Auth::attempt(['username'=> $req->username,'password'=> $req->password, 'usertype' => 1])){
            return redirect('/Admin');
        }
        return redirect('/AdminLogin')->with('message','No matching Login!')->with('type','error');
    }
}
