<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbllanguage extends Model
{
    protected $table = 'language'; //giống tên bảng trong wamp

    public $timestamps = false;

    public function language_ebook(){
        return $this->belongsToMany('App\tblebook', 'language_ebook', 'language_id','ebook_id' );
    }
}
