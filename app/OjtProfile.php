<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OjtProfile extends Model
{
    protected $table = 'ojt_profile';
    protected $primaryKey = 'ojt_profile_id';
    public $timestamps = false; 

    public function users(){
    	return $this->hasOne('App\Users','ojt_profile_id');
    }
    public function ojtlogs(){
    	return $this->hasMany('App\OjtLogs','ojt_profile_id');
    }

    public function schedule(){
    	return $this->belongsTo('App\Schedule','schedule_id');
    }
}
