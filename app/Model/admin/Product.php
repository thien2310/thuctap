<?php

namespace App\Model\admin;

use App\Model\Train\hasTag;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;


class Product extends Model
{
    use hasTag;
    // use sluggable;
    //

    public const STATUSES = [
        [
            'id' => 1,
            'name' => 'Kích hoạt',
            'type' => 'success'
        ],
        [
            'id' => 0,
            'name' => 'Chưa kích hoạt',
            'type' => 'danger'
        ],
    ];

    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'title'
    //         ]
    //     ];
    // }
    protected $fillable = [];

    const STATE = [
        [
            'id' => 1,
            'name' => 'Còn hàng',
            'type' => 'success'
        ],
        [
            'id' => 0,
            'name' => 'Hết hàng',
            'type' => 'danger' 
        ],
    ];


    public function category()
    {
        return $this->belongsTo(category::class, 'cate_id', 'id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }


    public function image()
    {
        return $this->morphOne(File::class, 'model')->where('custom_field', 'image');
    }

    public function origin()
    {
        return $this->belongsTo(origin::class, 'origin_id', 'id');
    }
}
