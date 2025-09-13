<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $productCategories = ProductCategory::where('is_active', 1)->get();
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('admin.layouts.pages.product.index', compact('productCategories', 'products'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'product_name'        => 'required|string|max:255|unique:products,product_name',
            'costing_price'       => 'required|numeric',
            'sales_price'         => 'required|numeric',
            'image'               => 'required|mimes:jpeg,jpg,png,gif,bmp,svg,webp,tiff,tif,avif|max:2048',
        ]);

        $newProductImage = $this->productImage($request);

        Product::create([
            'product_category_id' => $request->product_category_id,
            'product_name'        => $request->product_name,
            'costing_price'       => $request->costing_price,
            'sales_price'         => $request->sales_price,
            'image'               => $newProductImage,
            'status'              => $request->status,
        ]);

        Toastr::success('Product added successfully.');
        return redirect()->back();
    }

    public function show(Product $product)
    {
        //
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'product_name'        => 'required|string|max:255|unique:products,product_name,' . $product->id,
            'costing_price'       => 'required|numeric',
            'sales_price'         => 'required|numeric',
            'image'               => 'nullable|mimes:jpeg,jpg,png,gif,bmp,svg,webp,tiff,tif,avif|max:2048',
        ]);

        $newProductImage = $this->productImage($request);

        if ($newProductImage) {
            if (!empty($product->image)) {
                $oldImagePath = public_path($product->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $product->image = $newProductImage;
        }

        $product->update([
            'product_category_id' => $request->product_category_id,
            'product_name'        => $request->product_name,
            'costing_price'       => $request->costing_price,
            'sales_price'         => $request->sales_price,
            'image'               => $product->image,
            'status'              => $request->status,
        ]);

        Toastr::success('Product updated successfully.');
        return redirect()->back();
    }

    public function destroy(Product $product)
    {
        if ($product) {
            if (!empty($product->image)) {
                $oldImagePath = public_path($product->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $product->delete();

        Toastr::success('Product deleted successfully.');
        return redirect()->back();
    }

    private function productImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = Image::read($request->file('image'));
            $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('uploads/product_image/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->save($destinationPath . $imageName);

            return 'uploads/product_image/' . $imageName;
        }
        return null;
    }
}
