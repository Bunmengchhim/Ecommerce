<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request){

        $categories = Category::where('status','1')->get(); 

        $query = Brand::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $brands = $query->paginate(5);

        return view('admin.brand.index', compact('brands','categories'));
    }


    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'slug' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        // Create a new Category instance
        $brands = new Brand();
        $brands->name = $request->name;
        $brands->slug = $request->slug;
        $brands->category_id = $request->category_id;
        $brands->status = $request->status == true ? '1' : '0';

        // Save the category
        $brands->save();

        // Redirect to a success page or back with a success message
        return redirect('admin/brand')->with('success', 'Category created successfully.');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'slug' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->category_id = $request->category_id;        
        $brand->status = $request->status == true ? '1' : '0';
        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully.');
    }



    public function destroy($id)
    {
        $brands = Brand::findOrFail($id);
        $brands->delete();

        return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        Brand::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected Brands deleted successfully.']);
    }


        public function show($id)
    {
        $brands = Brand::findOrFail($id);
        return response()->json($brands);
    }
}
