<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorFormRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(Request $request){
        $query = Color::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $colors = $query->paginate(5);

        return view('admin.colors.index', compact('colors'));
    }

    public function create(){
        return view('admin.color.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
            'code' => 'required|string|max:255',
        ]);

        // Create a new Category instance
        $colors = new Color();
        $colors->name = $request->name;
        $colors->code = $request->code;
        $colors->status = $request->status == true ? '1' : '0';

        // Save the category
        $colors->save();

        // Redirect to a success page or back with a success message
        return redirect('admin/color')->with('success', 'Category created successfully.');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $id,
            'code' => 'required|string|max:255',
        ]);

        $color = Color::findOrFail($id);
        $color->name = $request->name;
        $color->code = $request->code;
        $color->status = $request->status == true ? '1' : '0';
        $color->save();

        return redirect()->route('color.index')->with('success', 'Color updated successfully.');
    }



    public function destroy($id)
    {
        $colors = Color::findOrFail($id);
        $colors->delete();

        return response()->json(['success' => true, 'message' => 'Color deleted successfully.']);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        Color::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected Colors deleted successfully.']);
    }


        public function show($id)
    {
        $colors = Color::findOrFail($id);
        return response()->json($colors);
    }
}
