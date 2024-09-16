<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
   
    public function index(Request $request)
    { 
        try {
            $data = $this->productService->getProducts($request);

            $products = $data['products'];
            $sortField = $data['sortField'];
            $sortOrder = $data['sortOrder'];
            $search = $data['search'];
    
            return view('products.index', compact('products', 'sortField', 'sortOrder', 'search'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'code' => 'required|string',
            'category' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'selling_price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            'status' => 'required|in:Draft,Published,Out of Stock',
            'is_delivery_available' => 'required|boolean',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'attributes.*.name' => 'required|string',
            'attributes.*.attribute_value' => 'required|string',
        ]);

        try {
            $product = $this->productService->createProduct($request);
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validate input
        $request->validate([
            'code' => 'required|string',
            'category' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'selling_price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            'status' => 'required|in:Draft,Published,Out of Stock',
            'is_delivery_available' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attributes.*.name' => 'required|string',
            'attributes.*.attribute_value' => 'required|string',
        ]);

        try {
            $product = $this->productService->updateProduct($request, $product);
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

  
    public function destroy(Product $product)
    {
        try {
            $product = $this->productService->deleteProduct($product);
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
