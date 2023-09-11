<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class category extends Model
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

    protected $table = 'categories';
    protected $fillable = [];

    public function childCategory(){
        return $this->hasMany(category::class,'parent_id');
    }

    public function searchName($data)
    {

        // DB::table('categories')->where('name', 'like', "?%", $data)->get();

    }
    public static function getForSelect() 
    {
        $all = self::select(['id', 'name', 'sort_order', 'level'])->orderBy('sort_order', 'asc')->get()->toArray();

        // $result = [];
        $result = array_map(function ($value) {
            if ($value['level'] == 1) {
                $value['name'] = ' |-- ' . $value['name'];
            }
            if ($value['level'] == 2) {
                $value['name'] = ' |-- |--' . $value['name'];
            }
            if ($value['level'] == 3) {
                $value['name'] = ' |-- |-- |--' . $value['name'];
            }
            if ($value['level'] == 4) {
                $value['name'] = ' |-- |-- |-- |--' . $value['name'];
            }
            return $value;
        }, $all);

        // dd($result);

        return $result;
    }

    public function add($data)
    {
        DB::insert('insert into categories (name, sort_order ,parent_id, level, created_at) value (?,?,?,?,?)', $data);
    }
    public function getId($id)
    {
        return DB::select('SELECT * from categories WHERE id = ? ', [$id]);
    }
    public function updataCategory($id, $data)
    {
        $data[] = $id;
        return DB::update('UPDATE categories SET name=?, sort_order = ?, parent_id =?, level =? , status = ? ,updated_at=? WHERE id = ?', $data);
    }

    public static function getAllForEdit($id)
    {
        DB::enableQueryLog();
        $all = self::where('id', '<>', $id)
            ->where('parent_id', '<>', $id)
            ->select(['id', 'name', 'sort_order', 'level', 'status'])
            ->orderBy('sort_order', 'asc')
            ->get()->toArray();

        // $all = DB::getQueryLog();
        // dd($all);
        $result = [];
        $result = array_map(function ($value) {
            if ($value['level'] == 1) {
                $value['name'] = ' |-- ' . $value['name'];
            }
            if ($value['level'] == 2) {
                $value['name'] = ' |-- |-- ' . $value['name'];
            }
            if ($value['level'] == 3) {
                $value['name'] = ' |-- |-- |-- ' . $value['name'];
            }
            if ($value['level'] == 4) {
                $value['name'] = ' |-- |-- |-- | --' . $value['name'];
            }
            return $value;
        }, $all);
        // dd($result);
        return $result;
    }
}
