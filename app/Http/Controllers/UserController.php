<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Users;
use App\OjtLogs;

class UserController extends Controller
{
    public function login(){
    	// Users::insert([
    	// 	'username' => 'lolo',
    	// 	'password' => bcrypt('lolo'),
    	// ]);
    	return view('login');
    }
    public function showAdminLogin(){
        return view('adminlogin');
    }

    public function doLogin(Request $req){
        if(Auth::attempt(['username'=> $req->username,'password'=> $req->password, 'usertype' => 0, 'deleted' => 0])){
            if ($req->submit == 'login') {   
                $log = OjtLogs::where('ojt_profile_id',Auth::user()->ojt_profile_id)->orderBy('dtime_in','DESC');
                if ($log->first() == "" || $log->first()->dtime_out != null) {
                    OjtLogs::insert([
                        'ojt_profile_id' => Auth::user()->ojt_profile_id,
                        'dtime_in' => date_create('now')->format('Y-m-d H:i:s')
                    ]);
                Auth::logout(); 
                return redirect('/')->with('message','Success!');
                }
                Auth::logout(); 
                return redirect('/')->with('message','Existing!');
            } else {
                $log = OjtLogs::where('ojt_profile_id',Auth::user()->ojt_profile_id)->orderBy('dtime_in','DESC')->limit(1);
                if ($log->first()->dtime_out == null) {
                    $log->update([ 'dtime_out' => date_create('now')->format('Y-m-d H:i:s')]);
                    Auth::logout(); 
                    return redirect('/')->with('message','Success!');
                }
                Auth::logout(); 
                return redirect('/')->with('message','Existing!');
            }
             
        }
        return redirect('/');
    }
    public function doLoginAdmin(Request $req){
        if(Auth::attempt(['username'=> $req->username,'password'=> $req->password, 'usertype' => 1])){
            return redirect('/Admin');
        }
        return redirect('/AdminLogin');
    }
}
