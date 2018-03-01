<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'schedule_id';
    public $timestamps = false; 

    public function ojtprofile(){
    	return $this->hasMany('App\OjtProfile','schedule_id');
    }
}
