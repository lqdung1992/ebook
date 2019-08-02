<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tblauthor extends Model
{
    protected $table = 'author'; //giống tên bảng trong wamp

    public $timestamps = false;

    public function author_ebook(){
        return $this->belongsToMany('App\tblebook', 'author_ebook', 'author_id','ebook_id' );
    }
}
