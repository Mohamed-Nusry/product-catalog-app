<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getProducts(Request $request)
    {
        // Get the queries
        $search = $request->input('search', '');
        $sortField = $request->input('sort', 'name'); // sort field
        $sortOrder = $request->input('order', 'asc'); // sort order
        
        // Validate sort field and order
        $validSortFields = ['code', 'category', 'name', 'description', 'selling_price', 'special_price', 'status', 'is_delivery_available', 'created_at', 'updated_at'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'name';
        }
        
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        // Fetch products with search, sorting, and pagination
        $products = Product::where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->orderBy($sortField, $sortOrder)
            ->paginate(10); // 10 products per page

        $data = [
            'products' => $products,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'search' => $search,
        ];

        return $data;
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

    public function updateProduct(Request $request, Product $product)
    {
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

    
    public function deleteProduct(Product $product)
    {
        // Delete the product image if it exists
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        // Delete the product
        $product->delete();
    }
}