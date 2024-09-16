<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\ProductApiService;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    use ApiResponseTrait;

    protected $productApiService;

    public function __construct(ProductApiService $productApiService)
    {
        $this->productApiService = $productApiService;
    }
   
    public function index()
    { 
        try {
            $products = $this->productApiService->getProducts();
            return $this->successResponse($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id)
    { 
        try {
            $product = $this->productApiService->getProductById($id);
            return $this->successResponse($product, 'Product retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            $response = $validator->messages();
            return $this->errorResponse($response);
        } 

        try {
            $product = $this->productApiService->createProduct($request);
            return $this->successResponse($product, 'Product created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            $response = $validator->messages();
            return $this->errorResponse($response);
        } 

        try {
            $product = $this->productApiService->updateProduct($request, $id);
            return $this->successResponse($product, 'Product updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

  
    public function destroy($id)
    {
        try {
            $product = $this->productApiService->deleteProduct($id);
            return $this->successResponse($product, 'Product deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
