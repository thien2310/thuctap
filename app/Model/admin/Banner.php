<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;

class Banner extends Model
{
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

    protected $table = 'banners';
    protected $fillable = [];

    public function image()
    { 
        return $this->morphOne(File::class, 'model')->where('custom_field', 'image');
    }
    public function canDelete()
    {
        return true;
    }
}
