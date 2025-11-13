<?php

namespace App\Http\Controllers\Basic;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\CommissionInstallment;

class InstallmentController extends Controller
{
    public function toCommission($id)
    {
        $order = Order::with(['user', 'sponsor'])->findOrFail($id);

        $total_installment = CommissionInstallment::where('order_id', $order->id)->sum('payment_amount');

        $installments = CommissionInstallment::where('order_id', $order->id)->cursor();

        return view('admin.orders.installment', compact('order', 'total_installment', 'installments'));
    }

    public function toInstallment(Request $request)
    {
        // Validate fields
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount'   => 'required|numeric|min:1',
            'remarks'  => 'nullable|string',
        ]);

        // Get order
        $order = Order::findOrFail($request->order_id);

        // Remaining commission calculation
        $previousPaid = CommissionInstallment::where('order_id', $order->id)->sum('payment_amount');
        $remaining = $order->total_amount - ($previousPaid + $request->amount);

        // Prevent negative remaining balance
        if ($remaining < 0) {
            return back()->with('error', 'Installment amount exceeds remaining Amount.');
        }

        // Create installment
        CommissionInstallment::create([
            'order_id'       => $order->id,
            'user_id'        => $order->user_id ?? null,
            'user_guard'     => $order->guard,
            'payment_amount' => $request->amount,
            'payment_remain' => $remaining,
            'remarks'        => $request->remarks,
        ]);

        return back()->with('success', 'Installment added successfully.');
    }
}
