<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbltype extends Model
{
    protected $table = 'type'; //giống tên bảng trong wamp

    public $timestamps = false;

    public function type_ebook(){
        return $this->belongsToMany('App\tblebook', 'type_ebook', 'type_id','ebook_id' );
    }
}
