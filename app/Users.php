<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
//    public $timestamps = true;
    public function Hire(){
        return $this->hasMany('App\Hire','users_id','id');
    }
    public function Comment() {
        return $this->hasMany('App\Comment','users_id','id');
    }

    public function Library() {
        return $this->hasMany('App\Library', 'library');
    }
}
