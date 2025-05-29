<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use App\Models\Category;


class AdminCategoryController extends Controller
{
    /*
    View Categories List
    Created On: 20-05-2025
    */
    public function index(Request $request){

        $query = Category::query();

        // Exclude soft-deleted (status = 2)
        $query->where('status', '!=', 2);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['1', '0'])) {
            $query->where('status', $request->status);
        }

        $parentCategories = Category::where('status', 1)->where('parent_id', NULL)->get();


        // Order by created_at and apply pagination
        $categories = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        if ($request->ajax()) {
            return view('admin.category.partials.table', compact('categories', 'parentCategories'))->render();
        }

        return view('admin.category.index', compact('categories', 'parentCategories'));
    }

    /*
    Store: Category
    Created On: 20-05-2025
    */
    public function store(Request $request)
    {
        $input = $request->all();
        Log::info('Input received:', $input);
        if (isset($input['parent_id']) && $input['parent_id'] == 0) {
            $input['parent_id'] = null;
        }

        $validated = validator($input, [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string|max:255',
            'parent_id'         => [
                'nullable',
                'integer',
                Rule::exists('categories', 'category_id')->where(function ($query) {
                    $query->where('status', '!=', 2);
                }),
            ],
            'image_url'         => 'required|image|mimes:jpeg,png,jpg,gif,svg,avif|max:10000',
            'display_order'     => 'required|integer',
        ])->validate();
            Log::info('Validated:', $validated);

        try {
            $imagePath = null;
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('img/uploads/category_imgs'), $imageName);
                $imagePath = 'img/uploads/category_imgs/' . $imageName;
            }

            $category = new Category();
            $category->name = $validated['name'];
            $category->description = $validated['description'];
            $category->parent_id = $validated['parent_id'];
            $category->image_url = $imagePath;
            $category->display_order = $validated['display_order'];
            $category->status = 0;
            $category->cat_code = 'CAT' . str_pad(Category::max('category_id') + 1, 4, '0', STR_PAD_LEFT);
            $category->save();

            return response()->json(['message' => 'Category added successfully!']);
        } catch (\Exception $e) {
            Log::error('Store error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to store category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /*
    Update: Category status
    Created On: 21-05-2025
    */
    public function updateStatus(Request $request, Category $category){
        $validated = $request->validate([
            'status' => 'required|in:0,1',
        ]);
        try{
            $category->status = $validated['status'];
            $category->save();
            return redirect()->back()->with('success', 'Category status updated successfully.');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update category status.');
        }
        
    }

    /*
    Delete: Category
    Created On: 21-05-2025
    */
    public function destroy($categoryId){
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->status = 2;
        $category->save();
        return response()->json(['success' => 'Category removed successfully']);
    }

    /*
    Bulk Delete: Category
    Created On: 21-05-2025
    */
    public function bulkDelete(Request $request)
    {
        $categoryIds = $request->input('categoryIds');
        if (is_array($categoryIds) && !empty($categoryIds)) {
            Category::whereIn('category_id', $categoryIds)->update(['status' => 2]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    /*
    Update: Category
    Created On: 21-05-2025
    */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validatedData = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'required|string|max:255',
            'parent_id'         => 'nullable|integer|exists:categories,category_id',
            'image_url'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif|max:10000',
            'display_order'     => 'required|integer',
        ]);

        $category->name         = $validatedData['name'];
        $category->description  = $validatedData['description'];
        $category->parent_id    = $validatedData['parent_id'] ?? null;
        $category->display_order= $validatedData['display_order'];
        $category->status       = $request->status;

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img/uploads/category_imgs'), $imageName);
            $category->image_url = 'img/uploads/category_imgs/' . $imageName;
        }

        $category->save();

        return response()->json($category->fresh());
    }
}
