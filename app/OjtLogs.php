<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OjtLogs extends Model
{
    protected $table = 'ojt_logs';
    public $timestamps = false; 

    public function ojtprofile(){
    	return $this->belongsTo('App\OjtProfile','ojt_profile_id');
    }
}
