<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tblebook extends Model
{
    protected $table = 'ebook'; //giống tên bảng trong wamp

    public $timestamps = false;

    public function publisher(){
        return $this->belongsTo('App\tblpublisher','publisher_id','id');
    }

    public function hire()
    {
    	return $this->belongsToMany('App\User', 'hire', 'ebook_id','user_id')
                    ->withPivot('hour_start', 'date_start','hour_end','date_end','hire_price','total_price')
                    ->withTimestamps();
    }

    public function comment()
    {
    	return $this->belongsToMany('App\User', 'comment', 'ebook_id','user_id');
    }

    public function library()
    {
    	return $this->belongsToMany('App\User', 'library', 'ebook_id','user_id');
    }
    
    public function language_ebook()
    {
        return $this->belongsToMany('App\tbllanguage', 'language_ebook', 'ebook_id','language_id');
    }

    public function type_ebook()
    {
        return $this->belongsToMany('App\tbltype', 'type_ebook', 'ebook_id','type_id');
    }

    public function author_ebook()
    {
        return $this->belongsToMany('App\tblauthor', 'author_ebook', 'ebook_id','author_id');
    }
}
