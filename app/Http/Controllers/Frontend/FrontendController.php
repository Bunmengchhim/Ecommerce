<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->get(); 
        return view('frontend.index', compact('sliders'));
    }

    public function categories()
    {
        $categories = Category::where('status', 1)->get();
         return view('frontend.collections.category.index',compact('categories'));
    }

    public function products($category_slug)
    {
        $categories = Category::where('slug', $category_slug)->first();
        if($categories)
        {
            $products = $categories->products()->get();
            return view('frontend.collections.products.index',compact('products', 'categories'));
        }
        else
        {
            return redirect()->back();
        }
    }


}
