<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderItem::with(['order', 'product'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $item = OrderItem::create($data);
        
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        return $orderItem->load(['order', 'product']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $data = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->json(null, 204);
    }
}
