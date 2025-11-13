<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function Products()
    {
        $products = Product::with(['category', 'subcategory'])->cursor();
        $categories = Category::all();
        return view('admin.product.products', compact('categories', 'products'));
    }

    public function addproduct()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.product.addproduct', compact('categories'));
    }


    public function productSave(Request $request)
    {
        // ✅ Validate only fields that are actually submitted
        $request->validate([
            'product' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'thumbphotos' => 'required',
            'multiple_image' => 'required',
            "mrp_price" => "required|numeric",
            "purchase_cost" => "required|numeric",
            "purchase_gst" => "required|numeric",
            "net_cost" => "required|numeric",
            "sale_price" => "required|numeric",
            "sale_gst" => "required|numeric",
            "payable_gst" => "required|numeric",
            "short_description" => "required|string",
            "terms_conditions" => "required|string",
            'status' => 'required|boolean',
            'in_stock' => 'required|boolean',
            'meta_title' => 'nullable|string|min:1',
            'meta_keywords' => 'nullable|string|min:1',
            'meta_description' => 'nullable|string|min:1',
        ]);

        // ✅ Create Product
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->subcategory_id;
        $product->product_name = $request->product;
        $product->product_slug = Str::slug($request->product);
        $product->thumbphotos = $request->thumbphotos;
        $product->multiple_image = $request->multiple_image;
        $product->short_description = $request->short_description;
        $product->terms_conditions = $request->terms_conditions;

        $product->mrp_price = $request->mrp_price;
        $product->purchase_cost = $request->purchase_cost;
        $product->purchase_gst = $request->purchase_gst;
        $product->net_cost = $request->net_cost;

        $product->sale_price = $request->sale_price;
        $product->sale_gst = $request->sale_gst;
        $product->payable_gst = $request->payable_gst;

        $product->status = $request->status;
        $product->in_stock = $request->in_stock;

        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;

        $product->save();

        return redirect()->back()->with('success', '✅ Product saved successfully.');
    }



    public function productEdit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.product.editproduct', compact('product', 'categories'));
    }
    public function productUpdate(Request $request, $id)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'thumbphotos' => 'required',
            'multiple_image' => 'required',
            "mrp_price" => "required|numeric",
            "purchase_cost" => "required|numeric",
            "purchase_gst" => "required|numeric",
            "net_cost" => "required|numeric",
            "sale_price" => "required|numeric",
            "sale_gst" => "required|numeric",
            "payable_gst" => "required|numeric",
            "short_description" => "required|string",
            "terms_conditions" => "required|string",
            'status' => 'required|boolean',
            'in_stock' => 'required|boolean',
            'meta_title' => 'nullable|string|min:1',
            'meta_keywords' => 'nullable|string|min:1',
            'meta_description' => 'nullable|string|min:1',
        ]);


        $product = Product::findOrFail($id);
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->subcategory_id;
        $product->product_name = $request->product;
        $product->product_slug = Str::slug($request->product);
        $product->thumbphotos = $request->thumbphotos;
        $product->multiple_image = $request->multiple_image;
        $product->short_description = $request->short_description;
        $product->terms_conditions = $request->terms_conditions;

        $product->mrp_price = $request->mrp_price;
        $product->purchase_cost = $request->purchase_cost;
        $product->purchase_gst = $request->purchase_gst;
        $product->net_cost = $request->net_cost;

        $product->sale_price = $request->sale_price;
        $product->sale_gst = $request->sale_gst;
        $product->payable_gst = $request->payable_gst;

        $product->status = $request->status;
        $product->in_stock = $request->in_stock;

        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }


    public function productDelete(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }
}
