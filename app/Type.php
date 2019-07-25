<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "type";

    protected $fillable = ['name'];

    public function Ebooks()
    {
        return $this->belongsToMany('App\Ebook', 'type_ebook');
    }
}
