<?php

namespace App\Model\common;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    //
    protected $fillable = [
        'name',
        'path',
        'model_id',
        'model_type',
        'custom_field'
    ]; 

    public function model()
    {
        return $this->morphTo();
    }

	public function removeFromDB() {
        $this->delete();
    }

}
