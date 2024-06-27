<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request){
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $categories = $query->paginate(5);

        return view('admin.category.index', compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg', // adjust max file size as needed
            'meta_title' => 'required|string|max:255',
            'meta_keywords' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
        ]);


        if ($request->hasFile('image')) {
            $uploadPath = 'category_images/';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($uploadPath, $filename, 'public');
        } else {
            $path = null;
        }


        // Create a new Category instance
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->image = $path;
        $category->meta_title = $request->meta_title;
        $category->meta_keywords = $request->meta_keywords;
        $category->meta_description = $request->meta_description;
        $category->status = $request->status == true ? '1' : '0';

        // Save the category
        $category->save();

        // Redirect to a success page or back with a success message
        return redirect('admin/category')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'slug' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // adjust max file size as needed
            'meta_title' => 'required|string|max:255',
            'meta_keywords' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
        ]);

        // Find the category by ID
        $category = Category::findOrFail($id);

        // Handle file upload if an image is provided
        
        if ($request->hasFile('image')) {
            $uploadPath = 'category_images/';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($uploadPath, $filename, 'public');
        } else {
            $path = null;
        }

        // Update category details
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->image = $path;
        $category->meta_title = $request->meta_title;
        $category->meta_keywords = $request->meta_keywords;
        $category->meta_description = $request->meta_description;
        $category->status = $request->status == true ? '1' : '0';

        // Save the updated category
        $category->save();

        // Redirect back with a success message
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }



    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete the image from storage if it exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Delete the category
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        // Fetch the categories to be deleted
        $categories = Category::whereIn('id', $ids)->get();

        // Delete images from storage if they exist
        foreach ($categories as $category) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
        }

        // Delete the categories
        Category::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected categories deleted successfully.']);
    }


        public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
    

    
}

