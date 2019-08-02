<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = "language";

    public function Ebooks()
    {
        return $this->belongsToMany('App\Ebook');
    }
}
