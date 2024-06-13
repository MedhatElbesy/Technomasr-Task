<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('orderitems')->get();
        if ($orders) {
            return ApiResponse::sendResponse(200, 'All Orders',  OrderResource::collection($orders));
        }
        return ApiResponse::sendResponse(404, 'Can`t find Orders');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::guard('user-api')->id());
        if ($user->cart ->count() == 0) {
            return ApiResponse::sendResponse(404,'cart is empty');
        }
        $firstCart = $user->cart->first();
        // dd($firstCart->quantity);
        // dd($user->cart->first()->id);
        DB::beginTransaction();
        try {
            $Order = Order::create(['user_id' => $user->id,'product_id' => $firstCart->product_id,'quantity'=>$firstCart->quantity]);
            foreach ($user->cart as $products) {
                $Product = Product::findOrFail($products['product_id']);
                // dd($Product);
                OrderItem::create([
                    'quantity'=> $products['quantity'],
                    'product_id'=> $Product->id,
                    'price'=> $Product->price,
                    'order_id'=> $Order->id,
                ]);
                $Product->save();
                }
                $user->cart()->delete();

                DB::commit();
                return ApiResponse::sendResponse(201, 'Order Created Successfully', new OrderResource($Order));

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::sendResponse(500, 'Order Creation Failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Order = Order::find($id);
        if(!$Order){
            return ApiResponse::sendResponse(404,'Order not found');
        }
        return ApiResponse::sendResponse(200,'Order', new OrderResource($Order));
    }

}
