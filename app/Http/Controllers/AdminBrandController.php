<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class AdminBrandController extends Controller
{

    /*
    View Brands List
    Created On: 14-05-2025
    */
    public function index(Request $request){

        $query = Brand::query();

        // Exclude soft-deleted (status = 2)
        $query->where('status', '!=', 2);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['1', '0'])) {
            $query->where('status', $request->status);
        }

        // Order by created_at and apply pagination
        $brands = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        if ($request->ajax()) {
            return view('admin.brand.partials.table', compact('brands'))->render();
        }

        return view('admin.brand.index', compact('brands'));
    }

    /*
    Store: Brand
    Created On: 14-05-2025
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string|max:255',
            'logo_url'      => 'required|image|mimes:jpeg,png,jpg,gif,svg,avif|max:10000',
        ]);
        $imagePath = null;
        if ($request->hasFile('logo_url')) {
            $image      = $request->file('logo_url');
            $imageName  = time() . '_' . $image->getClientOriginalName(); 
            $image->move(public_path('img/uploads/brand_logo_imgs'), $imageName); 
            $imagePath  = 'img/uploads/brand_logo_imgs/' . $imageName; 
        }
        try{
        $brand = new Brand();
        $brand->name            = $validated['name'];
        $brand->description     = $validated['description'];
        $brand->logo_url        = $imagePath;
        $brand->status          = 0;
        $brand->brand_code      = 'BRD' . str_pad(Brand::max('brand_id') + 1, 4, '0', STR_PAD_LEFT);
        $brand->save();
        return redirect()->back()->with('success', 'Brand added successfully!');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to store brand.');
        }
    }

    /*
    Update: Brand status
    Created On: 14-05-2025
    */
    public function updateStatus(Request $request, Brand $brand){
        $validated = $request->validate([
            'status' => 'required|in:0,1',
        ]);
        try{
            $brand->status = $validated['status'];
            $brand->save();
            return redirect()->back()->with('success', 'Brand status updated successfully.');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update brand status.');
        }
        
    }

    /*
    Delete: Brand
    Created On: 14-05-2025
    */
    public function destroy($brandId){
        $brand = Brand::find($brandId);
        if (!$brand) {
            return response()->json(['error' => 'Brand not found'], 404);
        }
        $brand->status = 2;
        $brand->save();
        return response()->json(['success' => 'Brand removed successfully']);
    }

    /*
    Bulk Delete: Brand
    Created On: 09-05-2025
    */
    public function bulkDelete(Request $request)
    {
        $brandIds = $request->input('brandIds');
        if (is_array($brandIds) && !empty($brandIds)) {
            Brand::whereIn('brand_id', $brandIds)->update(['status' => 2]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    /*
    Update: Brand
    Created On: 19-05-2025
    */
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'string|max:255',
            'logo_url'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif|max:10000',
            'status'        => 'required|in:0,1',
        ]);

        $brand->name        = $request->name;
        $brand->description = $request->description;
        $brand->status      = $request->status;

        if ($request->hasFile('logo_url')) {
            $image              = $request->file('logo_url');
            $imageName          = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img/uploads/brand_logo_imgs'), $imageName);
            $brand->logo_url    = 'img/uploads/brand_logo_imgs/' . $imageName;
        }

        $brand->save();

        return response()->json($brand->fresh());
    }


}