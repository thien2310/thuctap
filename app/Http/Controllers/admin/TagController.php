<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\admin\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    //
    private $tag;
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:tags',
            'code' => 'required|unique:tags'
        ], [
            'name.required' => 'Vui lòng nhập ',
            'name.unique' => 'Đã tồn tại tên tag',
            'code.required' => 'Vui lòng nhập ',
            'code.unique' => 'Đã tồn tại mã tag',
        ]);

        if (!$validate->passes()) {
            return response()->json([
                'code' => 0,
                'error' => $validate->errors()->toArray(),
                "message" => "Vui lòng thử lại",
                "alert-type" => "warning"
            ]);
        } else {

            DB::beginTransaction();
            try {

                // dd(Auth()->id());
                $this->tag->name = $request->name;
                $this->tag->code = $request->code;
                $this->tag->create_by = auth()->id();

                $this->tag->save();
                DB::commit();

                return response()->json([
                    'code' => 3,
                    "message" => "Thao tác thành công",
                    "alert-type" => "success"
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            };
        }
    }
}
