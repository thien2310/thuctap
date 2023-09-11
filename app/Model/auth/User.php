<?php

namespace App\Model\auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class User extends Model
{
    //

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password','remember_token','created_at','updated_at'];


    public function addUser($data){
        DB::insert('insert into users (name,email,password,remember_token,created_at) value (?,?,?,?,?)',$data);
    }
}
