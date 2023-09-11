<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Model\admin\category;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    //
    private $category;
    public function __construct(category $category)
    {
        $this->category = $category;
    }
    public function index()
    {
        $statuses = $this->category::STATUSES;
        $category = $this->category->orderBy('sort_order', 'asc')->paginate(7);
        return view('admin.category.index', compact('category', 'statuses'));
    }
    public function create()
    {
        $statuses = $this->category::STATUSES;
        $category = $this->category->getForSelect();
        // dd($categories);
        return view('admin.category.create', compact('category', 'statuses'));
    }
    public function store(Request $request)
    {


        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'name' => 'required|max:255|unique:categories',
            'file' => 'required|file|mimes:jpg,jpeg,png,webp|max:3000',

        ], [
            'name.required' => 'Vùi lòng nhập tên danh mục',
            'name.max' => 'Nhập tối đa mà 255:max',
            'parent_id.nullable' => 'Không được để trống',
            'name.unique' => 'Đã tồn tại tên danh mục',
            'file.image' => 'Chọn đúng định dạng ảnh',

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
                if ($request->parent_id) {
                    $parent = category::where('id', $request->parent_id)->first();
                    if ($parent->level + 1 > 3) {
                        return response()->json([
                            "code" => 2,
                            "message" => "Không quá 3 cấp",
                            "alert-type" => "warning"
                        ]);
                    }
                    $stt = category::where('parent_id', $request->parent_id)->count();
                    if ($stt > 0) {
                        $stt += $stt;
                    } else {
                        $stt = $parent->sort_order + 1;
                    }

                    $this->category->parent_id = $request->parent_id;
                    $this->category->level = $parent->level + 1;
                    $this->category->sort_order = $stt;
                } else {
                    $this->category->parent_id = 0;
                    $this->category->level = 0;
                    $this->category->sort_order = 0;
                }
                // Cập nhật lại stt các danh mục có stt lớn hơn
                if ($request->parent_id) {
                    foreach (category::where('sort_order', '>=', $stt)->where('id', '<>', $this->category->id)->orderBy('sort_order', 'asc')->get() as $item) {
                        $item->sort_order = $item->sort_order + 1;
                        $item->save();
                    }
                }

                // $path = 'files/';
                // $file = $request->file('file');
                // $file_name = time() . '_' . $file->getClientOriginalName();
                // // $upload = $file->storeAs($path, $file_name);
                // $upload = $file->storeAs($path, $file_name, 'public');
                // // dd($upload);
                // if ($file_name) {
                //     $this->category->file = $file_name;
                // }



                // dd($m);


                $this->category->name = $request->name;
                $this->category->status = $request->status;
                $this->category->save();
                // dd($this->category->id);

                if ($request->file) {
                    FileHelper::uploadFile($request->file, 'categories', $this->category->id, Category::class, 'image', 2);
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



        // $this->category->add($data);
        // return redirect()->back()->with('message', 'Thêm mới thành công');
    }

    public function showedit($id = 0)
    {
        // dd($id);
        $category = $this->category->getAllForEdit($id);
        // dd($category);
        $statuses = $this->category::STATUSES;

        if (!empty($id)) { 
            $categories = $this->category->find($id);
            // dd($categories);
            // dd($categories);
        } else {
            return redirect()->back()->with('warning', 'Không tồn tại liên kết');
        }

        return view('admin.category.edit', compact('categories', 'category', 'statuses'));
    }


    public function update($id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'name' => 'required|max:255',

        ], [
            'name.required' => 'Vùi lòng nhập tên danh mục',
            'name.max' => 'Nhập tối đa mà 255:max',
            'parent_id.nullable' => 'Không được để trống'
        ]);

        if (!$validate->passes()) {
            return response()->json([
                'code' => 0,
                'error' => $validate->errors()->toArray(),
                "message" => "Vui lòng thử lại",
                "alert-type" => "warning"
            ]);
        } else {

            $categories = $this->category->find($id);
            if ($request->parent_id) {
                $parent = $categories::where('id', $request->parent_id)->first();
                // dd($parent);
                if ($parent->level + 1 > 3) {
                    return response()->json([
                        "code" => 2,
                        "message" => "Không quá 3 cấp",
                        "alert-type" => "warning"
                    ]);
                }
                $stt = $categories::where('parent_id', $request->parent_id)->count();
                if ($stt > 0) {
                    $stt += $stt;
                } else {
                    $stt = $parent->sort_order + 1;
                }
                $data = [
                    $categories->name = $request->name,
                    $categories->sort_order = $stt,
                    $categories->parent_id = $request->parent_id,
                    $categories->level = $parent->level + 1,
                    $categories->status = $request->status,

                    date('Y-m-d H:i:s'),

                ];
            } else {
                $data = [
                    $request->name,
                    $categories->sort_order = 0,
                    $categories->parent_id = 0,
                    $categories->level = 0,
                    $request->status,
                    date('Y-m-d H:i:s'),
                ];
            }
        }

        // dd($request->parent_id);
        $this->category->updataCategory($id, $data);

        return response()->json([
            'code' => 3,
            "message" => "Thao tác thành công",
            "alert-type" => "success"
        ]);

        // return redirect()->back()->with('message', 'Thêm mới thành công');
    }


    public function deletel($id)
    {
        // dd($request);
        $categories = $this->category->find($id);
        $categories->delete();

        return response()->json(
            [
                "code" => 2,
                "message" => "Thao tác thành công!",
                "alert-type" => "success"
            ]
        );
    }

    public function search(Request $request)
    {
        $data = $request->search;
        $result = $this->category->where('name', 'like', "$data%")->get();

        // dd($result);
        return view('admin.category.search', compact('result'));
        // return view('admin.category.find');
    }

    public function find($id)
    {
        $itemCategories = $this->category->find($id);
        return view('admin.category.find', compact('itemCategories'));
    }

    public function changestatus(Request $request)
    {
        $status = $request->changeItem;
        $resultt = $this->category->where('status', 'like', "$status%")->get();

        return view('admin.category.findstatus', compact('resultt'));
    }
}
