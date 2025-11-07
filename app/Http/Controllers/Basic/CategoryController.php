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
        $categories = Category::orderBy('category_name', 'asc')->paginate(25);
        return view('admin.categories.categories', compact('categories'));
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

        $Category->image = $request->image;
        $Category->status = $request->status;

        if ($Category->save()) {
            return redirect()->back()->with('success', 'Category updated successfully');
        }
        return redirect()->back()->with('error', 'Category not updated');
    }
}
