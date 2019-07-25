<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tblpublisher extends Model
{
    protected $table = 'publisher'; //giống tên bảng trong wamp

    public $timestamps = false;

    public function ebook()
    {
    	return $this->hasMany('App\tblebook','publisher_id','id'); //tên bảng - tên khóa ngoại - khóa chínhcủa bảng này
    }
}
