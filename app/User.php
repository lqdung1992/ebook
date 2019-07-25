<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'email', 'img', 'phone', 'money'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param object $user
     * @return object mixed
     */
    public static function getImageLinkApi($user)
    {
        if ($user->img) {
            $user->img = asset('upload/user/' . $user->img);
        }

        return $user;
    }

    /**
     * Chuẩn code psr-2 là hàm kiểu camel (lạt đà 1 bướu), tức là bắt đầu phải bằng chữ thường
     * ký tự đầu chứ thứ 2 mới viết hoa
     * ex: getHire, hire, ...
     *
     */
    public function getHire()
    {
        return $this->hasMany('App\Hire', 'user_id', 'id');
    }
    public function getComment()
    {
        return $this->hasMany('App\Comment', 'user_id', 'id');
    }
    public function getLibrary()
    {
        return $this->belongsToMany('App\Ebook', 'library');
    }

    public function hire(){
        return $this->belongsToMany('App\tblebook', 'hire', 'user_id','ebook_id' )
                    ->withPivot('hour_start', 'date_start','hour_end','date_end','hire_price','total_price')
                    ->withTimestamps();
    }

    public function comment(){
        return $this->belongsToMany('App\tblebook', 'comment', 'user_id','ebook_id' );
    }

    public function library(){
        return $this->belongsToMany('App\tblebook', 'library', 'user_id','ebook_id' );
    }
}
