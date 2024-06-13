<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\CartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $currntUser = auth()->user();
        $userCartItems= Cart::where('user_id' , $currntUser->id)->get();
        return ApiResponse::sendResponse(200,'Cart Content',CartResource::collection($userCartItems) );
    }

    public function store(CartRequest $request)
    {
        $currntUser = auth()->user();
        $validatedData=$request->validated();
        $validatedData['user_id']=$currntUser->id;

        if (Cart::where([
            'product_id' => $validatedData['product_id'],
            'user_id' => $currntUser->id,
        ])->exists()) {
            return ApiResponse::sendResponse(403,'This product is already in your cart');
        }

        $cart = Cart::create($validatedData);
        return ApiResponse::sendResponse(201,"Created Successfully", new CartResource($cart));
    }

    public function update(UpdateCartRequest $request, Cart $cart)

    {
        $this->authorize('update',$cart);
        $stockValidation= $this->checkStock($request,$cart->product_id);
        $cart->update($request->validated());
        return ApiResponse::sendResponse(200,"Updated Successfully", new CartResource($cart));
    }
}
