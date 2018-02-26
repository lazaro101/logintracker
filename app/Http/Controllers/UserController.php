<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Users;

class UserController extends Controller
{
    

    public function login(){
    	// Users::insert([
    	// 	'username' => 'lolo',
    	// 	'password' => bcrypt('lolo'),
    	// ]);
    	return view('login');
    }

    public function doLogin(Request $req){
    	if(Auth::attempt(['username'=> $req->username,'password'=> $req->password])){
          	return redirect('/Admin');
        }
        return redirect('/');
    }
}
