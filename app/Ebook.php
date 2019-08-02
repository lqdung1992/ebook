<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ebook extends Model
{
    protected $table = "ebook";

    // các đối số có thể search
    public static $searchFields = [
        'id', 'name',
        'min_rate', 'max_rate', 'min_pagenum', 'max_pagenum',
        'min_hire_price', 'max_hire_price', 'max_price', 'min_price',
        'is_new', 'publisher_id', 'type'
    ];
    public $timestamps = false;
    // key của api về trang đang xem
    const PAGE_NO = 'pageno';

    const ORDER_BY = 'orderby';

    // key giới hạn item 1 trang
    const LIMIT = 'limit';

    /**
     * @param array $data
     * @return \Illuminate\Database\Query\Builder
     */
    public static function getQueryByCondition(array $data, $orderBy = 'views', $user_id = null)
    {
        $qr = Ebook::query();
        if (isset($data['name']) && $data['name']) {
            $operator = 'like';
            $name = "%" . $data['name'] . "%";
            $qr->leftJoin('author_ebook', 'ebook.id', '=', 'author_ebook.ebook_id')
                ->leftJoin('author', 'author_ebook.author_id', '=', 'author.id')
                ->leftJoin('type_ebook', 'ebook.id', '=', 'type_ebook.ebook_id')
                ->leftJoin('type', 'type_ebook.type_id', '=', 'type.id');
        
            $qr->orWhere('ebook.name', $operator, $name);
            $qr->orWhere('ebook.name_en', $operator, $name);
            $qr->orWhere('publisher.name', $operator, $name);
            // search author, type
            $qr->orWhere('author.name', $operator, $name);
            $qr->orWhere('type.name', $operator, $name);
        }
        $qr->leftJoin('publisher', 'ebook.publisher_id', '=', 'publisher.id');

        foreach ($data as $key => $datum) {
            if (!in_array($key, self::$searchFields)) {
                continue;
            }

            $operator = null;
            if ($datum === null) {
                continue;
            }

            switch ($key) {
                case 'min_rate':
                    $key = 'rate';
                    $operator = '>=';
                    break;
                case 'max_rate':
                    $key = 'rate';
                    $operator = '<=';
                    break;

                case 'min_pagenum':
                    $key = 'pagenum';
                    $operator = '>=';
                    break;

                case 'max_pagenum':
                    $key = 'pagenum';
                    $operator = '<=';
                    break;

                case 'min_hire_price':
                    $key = 'hire_price';
                    $operator = '>=';
                    break;
                case 'max_hire_price':
                    $key = 'hire_price';
                    $operator = '<=';
                    break;

                case 'min_price':
                    $key = 'price';
                    $operator = '>=';
                    break;
                case 'max_price':
                    $key = 'price';
                    $operator = '<=';
                    break;

                case 'is_new':
                    $key = 'new';
                case 'id':
                    $key = 'ebook.id';
                case 'publisher_id':
                    $operator = '=';
                    break;
            }

            if ($operator) {
                $qr->where($key, $operator, $datum);
            }
        }

        $qr->select(['ebook.*', 'publisher.name as publisher_name', 'ebook.new as is_new']);

        // get bookmark
        if ($data['type'] == 'library' && $user_id) {
            $qr->rightJoin('library', 'ebook.id', '=', 'library.ebook_id')
                ->where('library.user_id', '=', $user_id);
            $qr->addSelect('library.bookmark');
            $qr->groupBy(['library.ebook_id', 'library.user_id']);
        } else {
            $qr->addSelect(DB::raw('0 as bookmark'));
            $qr->groupBy(['ebook.id']);
        }

        if ($orderBy) {
            $orderBy = 'ebook.'.$orderBy;
        }
        $qr->orderBy($orderBy, "DESC");

        return $qr;
    }

    /**
     * @param $items
     * @return array|object with link
     */
    public static function getLinkApi($items)
    {
        foreach ($items as $key => $item) {
            if ($item->link_content) {
                $items[$key]->link_content = asset('backend/ebook/' . $item->link_content);
            }
            if ($item->image) {
                $items[$key]->image = asset('backend/image/ebook/' . $item->image);
            }
        }

        return $items;
    }

    public function getIsNewAttribute()
    {
        return $this->attributes['new'];
    }

    public function setIsNewAttribute($value)
    {
        $this->attributes['new'] = $value;
    }

    public function getComment()
    {
         return $this->hasMany('App\Comment', 'ebook_id', 'id');
    }
    public function getHire()
    {
         return $this->hasMany('App\Hire', 'ebook_id', 'id');
    }
    public function getLibrary()
    {
         return $this->hasMany('App\Library', 'library');
    }
    
    public function getPublisher()
    {
        return $this->belongsTo('App\Publisher', 'publisher_id', 'id');
    }

    public function Authors()
    {
        return $this->belongsToMany('App\Author', 'author_ebook');
    }

    public function Types()
    {
        return $this->belongsToMany('App\Type', 'type_ebook');
    }

    public function Languages()
    {
        return $this->belongsToMany('App\Language', 'language_ebook');
    }
}
