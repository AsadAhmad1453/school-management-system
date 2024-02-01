<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded=[];

    public function student(){
        return $this->belongsTo('App\Models\Student','student_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
