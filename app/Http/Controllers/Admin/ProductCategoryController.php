<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Intervention\Image\Laravel\Facades\Image;


class ProductCategoryController extends Controller
{
    public function index()
    {
        $productCategories = ProductCategory::orderBy('id', 'desc')->paginate(10);
        return view('admin.layouts.pages.product-category.index', compact('productCategories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories,category_name',
            'category_slug' => 'nullable|string|max:255|unique:product_categories,category_slug',
            'description'   => 'nullable|string|max:255',
            'image'         => 'required|mimes:jpeg,jpg,png,gif,bmp,svg,webp,tiff,tif,avif|max:2048',
            'is_active'     => 'required|in:0,1',
        ]);

        $newCategoryImage = $this->categoryImage($request);

        ProductCategory::create([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
            'description'   => $request->description,
            'image'         => $newCategoryImage,
            'is_active'     => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Product category added successfully.');
    }

    public function show(ProductCategory $productCategory)
    {
        //
    }

    public function edit(ProductCategory $productCategory)
    {
        return response()->json($productCategory);
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories,category_name,' . $productCategory->id,
            'category_slug' => 'nullable|string|max:255|unique:product_categories,category_slug,' . $productCategory->id,
            'description'   => 'nullable|string|max:255',
            'image'         => 'nullable|mimes:jpeg,jpg,png,gif,bmp,svg,webp,tiff,tif,avif|max:2048',
            'is_active'     => 'required|in:0,1',
        ]);

        $newCategoryImage = $this->categoryImage($request);

        if ($newCategoryImage) {
            if (!empty($productCategory->image)) {
                $oldImagePath = public_path($productCategory->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $productCategory->image = $newCategoryImage;
        }

        $productCategory->update([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
            'description'   => $request->description,
            'image'         => $productCategory->image,
            'is_active'     => $request->is_active,
        ]);

        return redirect()->route('admin.product-category.index')->with('success', 'Product category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory) {
            if (!empty($productCategory->image)) {
                $oldImagePath = public_path($productCategory->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $productCategory->delete();

        return redirect()->back()->with('success', 'Product category deleted successfully.');
    }

   private function categoryImage(Request $request)
{
    if ($request->hasFile('image')) {

        // Image load করা
        $imageFile = $request->file('image');
        $image = Image::make($imageFile->getRealPath());

        // Image নাম generate
        $imageName = time() . '-' . $imageFile->getClientOriginalName();

        // Destination path
        $destinationPath = public_path('uploads/category_image/');

        // Folder check এবং create
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Image save করা
        $image->save($destinationPath . $imageName);

        // Return public path
        return 'uploads/category_image/' . $imageName;
    }

    return null;
}

}
