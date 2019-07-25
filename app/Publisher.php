<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = "publisher";

    public function getEbook()
    {
        return $this->hasMany('App\Ebook', 'puslisher_id', 'id');
    }
}
