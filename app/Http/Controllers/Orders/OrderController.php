<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\Models\Role\Agent;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function toorders()
    {
        $orders = Order::with(['user', 'sponsor'])->orderBy('id', 'DESC')->get();
        return view('admin.orders.order', compact('orders'));
    }

    public function toOrderDelete(string $id)
    {
        $product = Order::findOrFail($id);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }

    function toOrderEdit($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function toOrderUpdate(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required',
            'order_status'   => 'required'
        ]);

        $order = Order::findOrFail($id);

        $order->payment_status = $request->payment_status;
        $order->order_status   = $request->order_status;


        /**
         * Commission Logic - Only apply ONCE
         */
        if ($request->commission_status == 1 && empty($order->commission_date)) {

            $order->commission_status = 1;
            $order->commission_date = now();
            $order->total_commission = $request->total_commission; // keep updated

            // Save the order first
            $order->save();

            // Update Commission Wallet
            if ($order->commission_user_id) {
                $agent = Agent::find($order->commission_user_id);

                if ($agent) {
                    $agent->commission += $request->total_commission; // ✅ Correct Add
                    $agent->save();
                }
            }
        } else {
            // Save normal order updates (when commission isn't applied today)
            $order->save();
        }

        return redirect()->back()->with('success', 'Order Updated Successfully.');
    }


    public function invoice($id)
    {
        $order = Order::with('items', 'user', 'sponsor')->findOrFail($id);
        return view('admin.orders.invoice', compact('order'));
    }
}
