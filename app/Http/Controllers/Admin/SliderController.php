<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request){
        $query = Slider::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sliders = $query->paginate(5);

        return view('admin.slider.index', compact('sliders'));
    }

    public function create(){
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255|unique:sliders,title',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Allow up to 10 MB
        ]);
    
        // Handle file upload if an image is provided
        if ($request->hasFile('image')) {
            $uploadPath = 'slider_images/';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($uploadPath, $filename, 'public');
        } else {
            $path = null;
        }
    
        // Create a new Slider instance
        $slider = new Slider();
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->image = $path;
        $slider->status = $request->status == true ? '1' : '0';
    
        // Save the slider
        $slider->save();
    
        // Redirect to a success page or back with a success message
        return redirect('admin/slider')->with('success', 'Slider created successfully.');
    }
    
    

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255|unique:sliders,title,' . $id,
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Find the slider by ID
        $slider = Slider::findOrFail($id);

        // Handle file upload if an image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
            // Delete old image if exists
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $slider->image = $imagePath;
        }

        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->status = $request->status == true ? '1' : '0';

        // Save the updated slider
        $slider->save();

        // Redirect back with a success message
        return redirect()->route('slider.index')->with('success', 'Slider updated successfully.');
    }



    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete the image from storage if it exists
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        // Delete the slider
        $slider->delete();

        return response()->json(['success' => true, 'message' => 'Slider deleted successfully.']);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        // Fetch the sli$sliders to be deleted
        $sliders = Slider::whereIn('id', $ids)->get();

        // Delete images from storage if they exist
        foreach ($sliders as $slider) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
        }

        // Delete the sli$sliders
        Slider::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected sli$sliders deleted successfully.']);
    }


        public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return response()->json($slider);
    }
}
