<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with(['items.product', 'customer'])->get();
    }

    public function myOrders(Request $request)
    {
        return $request->user()->orders()->with('items.product')->get();
    }

    public function myOrder(Request $request, $id)
    {   
        return $request->user()->orders()->with('items.product')->findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = $request->user()->orders()->create([
            'status' => 'pending',
            'total_price' => 0,
        ]);

        $total = 0;

        foreach ($data['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);

            $total += $product->price * $item['quantity'];
        }

        $order->update(['total_price' => $total]);

        return response()->json($order->load('items.product'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $order->load(['items.product', 'customer']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id' => 'sometimes|required|exists:customers,id',
            'status' => 'sometimes|required|string',
        ]);

        $order->update($data);

        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(null, 204);
    }
}
