<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $products = Product::with(['attributes', 'categories:id'])
        ->when($request->search, function($query) use($request) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        })
        ->when($request->sort_by, function($query) use($request) {
            if ($request->sort_by == 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort_by == 'highest_price') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort_by == 'lowest_price') {
                $query->orderBy('price', 'asc');
            }
        })
        ->get();

    if ($products->isNotEmpty()) {
        return ApiResponse::sendResponse(200, 'All Products', ProductResource::collection($products));
    }

    return ApiResponse::sendResponse(404, 'Can`t find Products');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest  $request)
    {
        $data = $request->validated();
        $product = Product::create($request->only(['name','description','price']));
        if ($request->has('attributes')) {
            foreach ($request->post('attributes') as $attribute) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_name' => $attribute['name'],
                    'attribute_value' => $attribute['value'],
                ]);
            }
        }
        if($product)

            if ($request->has('categories')) {
                $product->categories()->sync($request->input('categories'));
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();

                if (!$image->move(public_path('images'), $imageName)) {
                return ApiResponse::sendResponse(500, 'Failed to upload product image');
                }
                $product->image =$imageName;
                $product->save();
            }
        return ApiResponse::sendResponse(201,'Product Created Successfully',new ProductResource($product));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['attributes','categories:id'])->findOrFail($id);
        if($product){
            return ApiResponse::sendResponse(200,'Product', new ProductResource($product));
        }
        return ApiResponse::sendResponse(404, 'Can`t find this Product');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request , $id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return ApiResponse::sendResponse(404, 'Product not found');
        }

        $data = $request->validated();
        $oldImagePath = $product->image;

        $product->fill($request->only(['name','description','price']));

        $product->save();

        if ($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        }

        if ($request->hasFile('image')) {
            if ($oldImagePath) {
                Storage::delete('public/images/' . $oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }
        $product->save();
        return ApiResponse::sendResponse(200, 'Product Updated Successfully',new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $product = Product::with('attributes')->findOrFail($id);

        if (is_null($product)) {
            return ApiResponse::sendResponse(404, 'Product not found');
        }

        if ($product->image) {
            Storage::delete('public/images/' . $product->image);
        }

        $product->categories()->detach();
        $product->attributes()->delete();
        $product->delete();
        return ApiResponse::sendResponse(200, 'Product Deleted Successfully');
    }
}
