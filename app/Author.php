<?php

//namespace App\Model;
namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = "author";

    public $timestamps = false;

    public function Ebooks()
    {
        return $this->belongsToMany('App\Ebook');
    }
}
