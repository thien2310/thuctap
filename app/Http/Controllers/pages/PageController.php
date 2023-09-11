<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Model\admin\Banner;
use App\Model\admin\category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    private $category;
    private $banner;
    public function __construct(category $category, Banner $banner)
    {

        $this->category = $category;
        $this->banner = $banner;
    }

    public function index()
    {
        $parentCategory = $this->category->where('parent_id', '=', '0')->where('status', '=', '1')->take(3)->get();
        $banner = $this->banner->where('status', '=', '1')->take(3)->get();

        return view('pages.layout.mainFE', compact('parentCategory', 'banner'));
    }
}
