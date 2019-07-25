<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Hire extends Model
{
    const OUT_DATE = 0;
    const EXPIRY_DATE = 1;
    const ALL = 2;

    protected $table = "hire";

    /**
     * @param $user
     * @param $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getRentEbookQuery($user, $type)
    {
        $query = Hire::query()->leftJoin('ebook', 'hire.ebook_id', '=', 'ebook.id')
            ->join('users', 'hire.user_id', '=', 'users.id')
            ->leftJoin('publisher', 'ebook.publisher_id', '=', 'publisher.id')
            ->where('users.id', '=', $user->id)
            ->select(['hire.*', 'ebook.name as ebook_name', 'ebook.link_content', 'ebook.image'])
            ->addSelect('ebook.new as is_new')
            ->addSelect('publisher.name as publisher_name')
            ->addSelect('publisher.id as publisher_id')
            ->orderByDesc('hire.date_end')
            ->orderByDesc('hire.hour_end');

        switch ($type) {
            case self::EXPIRY_DATE:
                $now = new \DateTime();
                $query->where(DB::raw("concat(`date_end`, ' ', `hour_end`)"), ">=", $now->format('Y-m-d H:i'));
                break;
            case self::ALL:
                break;
            case self::OUT_DATE:
                $now = new \DateTime();
                $query->where(DB::raw("concat(`date_end`, ' ', `hour_end`)"), "<=", $now->format('Y-m-d H:i'));
                break;
        }

        return $query;
    }

    /**
     * @param User $user
     * @param int $ebook
     * @return int
     */
    public static function checkRentedBook(User $user, $ebook_id)
    {
        $query = Hire::query()->leftJoin('ebook', 'hire.ebook_id', '=', 'ebook.id')
            ->join('users', 'hire.user_id', '=', 'users.id')
            ->leftJoin('publisher', 'ebook.publisher_id', '=', 'publisher.id')
            ->where('users.id', '=', $user->id)
            ->where('ebook.id', '=', $ebook_id);
//            ->addSelect('ebook.new as is_new')
//            ->addSelect('publisher.name as publisher_name')
//            ->addSelect('publisher.id as publisher_id')
//            ->orderByDesc('hire.date_end')
//            ->orderByDesc('hire.hour_end');

        $now = new \DateTime();
        $query->where(DB::raw("concat(`date_end`, ' ', `hour_end`)"), ">=", $now->format('Y-m-d H:i'));

        return $query->count();
    }

    public function ebook()
    {
        return $this->belongsTo('App\Ebook','id', 'ebook_id');
    }
}
