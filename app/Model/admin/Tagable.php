<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;

class Tagable extends Model
{
    //
    protected $table = 'tagables';

    protected $fillable = ['id', 'tagable_type', 'tagable_id', 'tag_id'];

    
}
