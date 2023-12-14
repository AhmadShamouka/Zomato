<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function getall()
    {
        $orders = Order::all();

        return response()->json([
            'status' => 'success',
            'orders' => $orders,
        ]);
    }

    public function get_one($id)
    {
      
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'order' => $order,
        ]);
    }

    public function create_order(Request $request)
    {
       
        $user = Auth::user();

        $request->validate([
            'order' => 'required',
            'price' => 'required',
        ]);

        $order = Order::create([
            'order' => $request->order,
            'price' => $request->price,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'order' => $order,
        ]);
    }

    public function update_order(Request $request, $id)
    {
       
        $user = Auth::user();
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ]);
        }

        if ($order->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission denied. You are not the owner of this order.',
            ]);
        }

        $request->validate([
            'order' => 'string|max:255',
            'price' => 'numeric',
        ]);

        $order->update($request->only(['order', 'price']));

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'order' => $order,
        ]);
    }

    public function delete($id)
    {
        $user = Auth::user();
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ]);
        }

        if ($order->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission denied. You are not the owner of this order.',
            ]);
        }

        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully',
        ]);
    }
}