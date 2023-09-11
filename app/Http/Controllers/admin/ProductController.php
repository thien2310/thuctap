<?php

namespace App\Http\Controllers\admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Model\admin\category;
use App\Model\admin\Manufacturer;
use App\Model\admin\origin;
use App\Model\admin\Product;
use App\Model\admin\Tag;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    //
    private $product;
    private $category;
    private $origin;
    private $manufacturer;
    private $tag;
    public function __construct(Product $product, Category $category, Origin $origin, Manufacturer $manufacturer, Tag $tag)
    {
        $this->product = $product;
        $this->category = $category;
        $this->origin = $origin;
        $this->manufacturer = $manufacturer;
        $this->tag = $tag;
    }


    public function index()
    {
        $products = $this->product->paginate(8);

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {

        $state = $this->product::STATE;
        $statuses = $this->product::STATUSES;
        $categorySelect = $this->category->getForSelect();
        $origins = $this->origin->get();
        $manufacturers = $this->manufacturer->get();
        $tags = $this->tag->latest()->get();

        return view('admin.product.create', compact('statuses', 'categorySelect', 'origins', 'manufacturers', 'tags', 'state'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'cate_id' => 'required',
            'name' => 'required',
            'origin' => 'required',
            'manufacturer' => 'required',
            'price' => 'required',
            'status' => 'required',
            'state' => 'required',


        ], [
            'name.required' => 'Vùi lòng nhập tên sản phẩm',
            'cate_id.required' => 'Vùi lòng chọn danh mục sản phẩm',
            'origin.required' => 'Vùi lòng chọn hãng sản xuất',
            'manufacturer.required' => 'Vùi lòng chọn nơi xuất xứ',
            'price.required' => 'Nhập giá sản phẩm',
            'status.required' => 'Vui lòng chọn',
            'state.required' => 'Vui lòng chọn',
        ]);

        if (!$validate->passes()) {
            return response()->json([
                'code' => '0',
                'message' => 'Vui lòng thử lại',
                'error' => $validate->errors()->toArray(),
                "alert-type" => "warning"
            ]);
        } else {

            // dd(123);
            DB::beginTransaction();
            try {
                $this->product->name = $request->name;
                $this->product->cate_id = $request->cate_id;
                $this->product->origin_id = $request->origin;
                $this->product->manufacturer_id = $request->manufacturer;
                $this->product->price = $request->price;
                $this->product->base_price = $request->base_price;
                $this->product->intro = $request->intro;
                $this->product->body = $request->body;
                $this->product->state = $request->state;
                $this->product->status = $request->status;
                $this->product->create_by = Auth()->id();
                $this->product->slug = Str::slug($request->name);


                $this->product->save();

                if (isset($request->all()['tags'])) {
                    $this->product->addTag($request->all()['tags']);
                }
                // dd($request->image);
                // FileHelper::updateFile($request->image, 'products', $this->product->id, Product::class, 'image', 1);
                if ($request->image) {
                    FileHelper::uploadFile($request->image, 'products', $this->product->id, Product::class, 'image', 1);
                }
                DB::commit();

                return response()->json([
                    'code' => '1',
                    'message' => 'Thành công',
                    "alert-type" => "success"
                ]);
            } catch (Exception $ex) {
                DB::rollBack();
                throw new Exception($ex->getMessage());
            }
        }
    }

    public function edit($id)
    {

        $state = $this->product::STATE;
        $statuses = $this->product::STATUSES;

        $product = Product::find($id);
        $categorySelect = $this->category->getForSelect();
        $origins = $this->origin->get();
        $manufacturers = $this->manufacturer->get();
        $tags = $this->tag->latest()->get();

        // dd($tags);
        // dd($product);

        // foreach($product->tags as $key){
        //     dd($key->id);
        // }

        // dd($product->tags);
        return view('admin.product.edit', compact('product', 'categorySelect', 'origins', 'manufacturers', 'tags', 'state', 'statuses'));
    }

    public function update($id, Request $request)
    {

        $validate = Validator::make($request->all(), [
            'cate_id' => 'required',
            'name' => 'required',
            'origin' => 'required',
            'manufacturer' => 'required',
            'price' => 'required',
            'status' => 'required',
            'state' => 'required',


        ], [
            'name.required' => 'Vùi lòng nhập tên sản phẩm',
            'cate_id.required' => 'Vùi lòng chọn danh mục sản phẩm',
            'origin.required' => 'Vùi lòng chọn hãng sản xuất',
            'manufacturer.required' => 'Vùi lòng chọn nơi xuất xứ',
            'price.required' => 'Nhập giá sản phẩm',
            'status.required' => 'Vui lòng chọn',
            'state.required' => 'Vui lòng chọn',
        ]);

        if (!$validate->passes()) {
            return response()->json([
                'code' => '0',
                'message' => 'Vui lòng thử lại',
                'error' => $validate->errors()->toArray(),
                "alert-type" => "warning"
            ]);
        } else {
            DB::beginTransaction();
            try {


                $oject = $this->product->findOrFail($id);

                $oject->name = $request->name;
                $oject->cate_id = $request->cate_id;
                $oject->origin_id = $request->origin;
                $oject->manufacturer_id = $request->manufacturer;
                $oject->price = $request->price;
                $oject->base_price = $request->base_price;
                $oject->intro = $request->intro;
                $oject->body = $request->body;
                $oject->state = $request->state;
                $oject->status = $request->status;
                $oject->update_by = Auth()->id();
                $oject->slug = Str::slug($request->name);

                $oject->save();



                if (isset($request->all()['tags'])) {
                    $oject->updateTags($request->all()['tags']);
                }
                // dd($request->image);
                // FileHelper::updateFile($request->image, 'products', $this->product->id, Product::class, 'image', 1);




            } catch (Exception $ex) {
                DB::rollBack();
                throw new Exception($ex->getMessage());
            }
        }
    }
}
