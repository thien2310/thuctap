<?php

namespace App\Http\Controllers\admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Model\admin\Banner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    //
    private $banner;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }

    public function index()
    {
        $banner = $this->banner->paginate(6);

        return view('admin.banner.index', compact('banner'));
    }
    public function create()
    {

        $status = $this->banner::STATUSES;

        return view('admin.banner.create', compact('status'));
    }

    public function store(Request $request)
    {
        // dd($request->file);
        $validate = Validator::make($request->all(), [

            'name' => 'required|max:255|unique:banners',
            'file' => 'required|file|mimes:jpg,jpeg,png,webp|max:3000',
            'intro' => 'required|max:255'

        ], [
            'name.required' => 'Vùi lòng nhập tên banner',
            'name.max' => 'Nhập tối đa mà 255:max',
            'parent_id.nullable' => 'Không được để trống',
            'name.unique' => 'Đã tồn tại tên danh mục',
            'file.image' => 'Chọn đúng định dạng ảnh',
            'file.required' => 'Vui lòng chọn ảnh',

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

                $this->banner->name = $request->name;
                $this->banner->status = $request->status;
                $this->banner->intro = $request->intro;
                $this->banner->save();

                if ($request->file) {
                    FileHelper::uploadFile($request->file, 'banner', $this->banner->id, Banner::class, 'image');
                }

                DB::commit();
                return response()->json([
                    'code' => 3,
                    "message" => "Thao tác thành công",
                    "alert-type" => "success"
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }
        }
    }

    public function edit($id)
    {

        $banner = $this->banner->find($id);
        $statuses = $this->banner::STATUSES;

        return view('admin.banner.edit', compact('banner', 'statuses'));
    }
    public function update($id, Request $request)
    {

        $validate = Validator::make($request->all(), [

            'name' => 'required|max:255',
            'file' => 'file|mimes:jpg,jpeg,png,webp|max:3000',
            'intro' => 'required|max:255'

        ], [
            'name.required' => 'Vùi lòng nhập tên banner',
            'name.max' => 'Nhập tối đa mà 255:max',
            'parent_id.nullable' => 'Không được để trống',
            'name.unique' => 'Đã tồn tại tên danh mục',
            'file.image' => 'Chọn đúng định dạng ảnh',
            'file.required' => 'Vui lòng chọn ảnh',

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

                $object = $this->banner::findOrFail($id);
                $object->name = $request->name;
                $object->intro = $request->intro;
                $object->status = $request->status;


                $object->save();


                if ($request->file) {

                    if ($object->image) {
                        FileHelper::forceDeleteFiles($object->image->id, $object->id, Banner::class, 'image');
                    }
                    FileHelper::uploadFile($request->file, 'banner', $object->id, Banner::class, 'image');
                }

                DB::commit();

                return response()->json([
                    'code' => 3,
                    "message" => "Thành công",
                    "alert-type" => "Success"

                ]);
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }
        }
    }

    public function delete($id)
    {
        $banner = $this->banner->findOrFail($id);

        if (!$banner->canDelete()) {

            return response()->json([
                'code' => 0,
                "message" => "Không thể xóa!!",
                "alert-type" => "warning"
            ]);
        } else {

            $banner->delete();
            return response()->json([
                'code' => 1,
                "message" => "Xóa thành công",
                "alert-type" => "success"
            ]);
        }
    }
}
