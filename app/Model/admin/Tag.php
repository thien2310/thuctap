<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags';
    protected $fillable = [];


        public function products()
        {
            return $this->morphedByMany(Product::class, 'tagable');
        }
}
