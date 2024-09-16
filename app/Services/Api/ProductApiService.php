<?php

namespace App\Services\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductApiService
{
    public function getProducts()
    {
        // Get all products
        $products = Product::with('attributes')->get();

        return $products;
    }

    public function getProductById($id)
    {
        // Check product exist
        $check = Product::where('id', $id)->count();

        if($check <= 0) {
            abort(404, 'Not found');
        }

        // Get product by id
        $products = Product::with('attributes')->where('id', $id)->get();

        return $products;
    }

    public function createProduct(Request $request)
    {
        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Create the product
        $product = Product::create([
            'code' => $request->input('code'),
            'category' => $request->input('category'),
            'name' => $request->input('name'),
            'description' => $request->input('description') ?? null,
            'selling_price' => $request->input('selling_price'),
            'special_price' => $request->input('special_price') ?? null,
            'status' => $request->input('status'),
            'is_delivery_available' => $request->input('is_delivery_available'),
            'image' => $imagePath,
        ]);

        // Attach attributes to the product
        $attributes = $request->input('attributes', []);
        foreach ($attributes as $attribute) {
            $product->attributes()->create([
                'name' => $attribute['name'],
                'attribute_value' => $attribute['attribute_value'],
            ]);
        }

        return $product;
    }

    public function updateProduct(Request $request, $id)
    {
        $check = Product::where('id', $id)->count();

        if($check <= 0) {
            abort(404, 'Not found');
        }

        $product = Product::where('id', $id)->first();

        // Handle the image upload
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Delete the old image
            if ($imagePath && Storage::exists('public/' . $imagePath)) {
                Storage::delete('public/' . $imagePath);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Update the product
        $product->update([
            'code' => $request->input('code'),
            'category' => $request->input('category'),
            'name' => $request->input('name'),
            'description' => $request->input('description') ?? null,
            'selling_price' => $request->input('selling_price'),
            'special_price' => $request->input('special_price') ?? null,
            'status' => $request->input('status'),
            'is_delivery_available' => $request->input('is_delivery_available'),
            'image' => $imagePath,
        ]);

        // Update attributes
        $attributes = $request->input('attributes', []);

        if(count($attributes) > 0) {
            //Delete all attributes first
            $product->attributes()->delete();
        }

        foreach ($attributes as $index => $attribute) {
            // Create new attribute
            $product->attributes()->create([
                'name' => $attribute['name'],
                'attribute_value' => $attribute['attribute_value'],
            ]);
        }

        return $product;
    }

    
    public function deleteProduct($id)
    {
        $check = Product::where('id', $id)->count();

        if($check <= 0) {
            abort(404, 'Not found');
        }

        $product = Product::where('id', $id)->first();

        // Delete the product image if it exists
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        // Delete the product
        $product->delete();
    }
}