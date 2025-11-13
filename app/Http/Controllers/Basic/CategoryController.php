<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function toCategories()
    {
        $categories = Category::with('parent')
            ->orderBy('parent_id', 'asc')
            ->orderBy('category_name', 'asc')
            ->cursor();

        $parents = Category::whereNull('parent_id')
            ->orderBy('category_name')
            ->get();

        return view('admin.categories.categories', compact('categories', 'parents'));
    }

    function toCategoriesAdd(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',

            'image' => 'nullable|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->user_id =  Auth::id();
        $category->guard = current_guard();

        $category->category_slug = Str::slug($request->category_name);

        $category->parent_id = $request->parent_id ?? null;

        $category->image = $request->image;

        $category->status = $request->status;
        if ($category->save()) {
            return redirect()->back()->with('success', 'Category added successfully');
        }
        return redirect()->back()->with('error', 'Category not added');
    }


    function toCategoriesdelete($id)
    {
        $item = Category::where('user_id', Auth::id())->where('guard', current_guard())->findOrFail($id);
        if ($item->delete()) {
            return response()->json(['success' => 'Item deleted successfully.']);
        }
        return response()->json(['error' => 'Item not deleted.']);
    }


    function toCategoriesUpdate(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|unique:categories,category_name,' . $request->id,
            'status' => 'required|integer|in:0,1',
        ]);

        $Category = Category::where('user_id', Auth::id())->where('guard', current_guard())->findOrFail($request->input('id'));
        $Category->category_name = $request->category_name;
        $Category->category_slug = Str::slug($request->category_name);
        $Category->user_id = Auth::id();
        $Category->guard = current_guard();
        $Category->parent_id = $request->parent_id ?? null;
        $Category->image = $request->image;
        $Category->status = $request->status;

        if ($Category->save()) {
            return redirect()->back()->with('success', 'Category updated successfully');
        }
        return redirect()->back()->with('error', 'Category not updated');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Category::where('parent_id', $categoryId)->where('status', 1)->get();
        return response()->json($subcategories);
    }
}
