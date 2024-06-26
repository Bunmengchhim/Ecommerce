<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query(); // Eager load the category

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->paginate(5);

        return view('admin.product.index', compact('products'));
    }

    public function create(){
        $brands = Brand::all();
        $categories = Category::all();
        $colors = Color::all();
        return view('admin.product.create', compact('brands','categories','colors'));
    }

    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();

        $product = Product::create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['slug']),
            'brand' => $validatedData['brand'],
            'small_description' => $validatedData['small_description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'trending' => $request->has('trending') ? 1 : 0,
            'status' => $request->has('status') ? 1 : 0,
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
        ]);

        if ($request->hasFile('images')) {
            $uploadPath = 'uploads/products/';
            $i = 1;
            foreach ($request->file('images') as $imageFile) {
                $filename = time() . $i++ . '_' . $imageFile->getClientOriginalName();
                $path = $imageFile->storeAs($uploadPath, $filename, 'public');
                $productImage = new ProductImage([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
                $product->productImages()->save($productImage);
            }
        }

        if($request->colors){
            foreach($request->colors as $key => $color){
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->color_quantity[$key] ?? 0
                ]);
            }
        }
        

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

     public function edit($id)
    {
        $brands = Brand::all(); 
        $categories = Category::all();
        $product = Product::findOrFail($id);

        $product_color = $product->productColors->pluck('color_id')->toArray() ;     
        $colors = Color::whereNotIn('id',$product_color)->get();


        return view('admin.product.edit', compact('product', 'brands', 'categories','colors'));
    }
    public function update(ProductFormRequest $request, $id)
    {
        $validatedData = $request->validated();

        $product = Product::findOrFail($id);

        $product->update([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['slug']),
            'brand' => $validatedData['brand'],
            'small_description' => $validatedData['small_description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'trending' => $request->has('trending') ? 1 : 0,
            'status' => $request->has('status') ? 1 : 0,
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
        ]);

        if ($request->hasFile('images')) {
            $uploadPath = 'uploads/products/';
            $i = 1;
            foreach ($request->file('images') as $imageFile) {
                $filename = time() . $i++ . '_' . $imageFile->getClientOriginalName();
                $path = $imageFile->storeAs($uploadPath, $filename, 'public');
                $productImage = new ProductImage([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
                $product->productImages()->save($productImage);
            }
        }

        if($request->colors){
            foreach($request->colors as $key => $color){
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->color_quantity[$key] ?? 0
                ]);
            }
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }  
    public function deleteImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->productImages()->findOrFail($imageId);
    
        if ($image) {
            // Assuming the image path is stored with 'uploads/products/' prefix
            Storage::disk('public')->delete($image->image);
    
            $image->delete();
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

    
        // Delete the category
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }
    public function updateColorQuantity(Request $request, $productId, $colorId)
    {
        $productColor = ProductColor::where('product_id', $productId)
                                    ->where('color_id', $colorId)
                                    ->firstOrFail();

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $productColor->quantity = $validatedData['quantity'];
        $productColor->save();

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully.']);
    }
    public function deleteColor($productId, $colorId)
    {
        $productColor = ProductColor::where('product_id', $productId)
                                    ->where('color_id', $colorId)
                                    ->firstOrFail();
    
        $productColor->delete();
    
        return response()->json(['success' => true, 'message' => 'Color deleted successfully.']);
    }
    


}
