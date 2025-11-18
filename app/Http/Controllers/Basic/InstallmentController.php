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

        $total_installment = CommissionInstallment::where('order_id', $order->id)->where('status', 1)->sum('payment_amount');

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
        $previousPaid = CommissionInstallment::where('order_id', $order->id)->where('status', 1)->sum('payment_amount');
        $remaining = $order->total_amount - ($previousPaid + $request->amount);


        $PendingCommission = CommissionInstallment::where('order_id', $order->id)->where('status', 0)->count();


        if ($PendingCommission > 0) {
            return back()->with('error', 'Installment amount Already into Pending.');
        }

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
            'remarks'        => $request->remarks ?? null,

            'payment_by'    => current_guard(),
            'utr_id'        => $request->utr_id ?? null,
            'payment_image' => $request->payment_image ?? null,

            'status'        => 0,
        ]);

        return back()->with('success', 'Installment added successfully.');
    }

    function toinstallmentUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:commission_installments,id',
            'status' => 'required|in:1,2,3'
        ]);

        $ins = CommissionInstallment::find($request->id);
        $ins->status = $request->status;
        $ins->save();

        return response()->json([
            'success' => true,
            'message' => 'Installment status updated successfully!'
        ]);
    }



    public function toCommissionAgent($order_id)
    {
        $id = decrypt($order_id);

        $order = Order::with(['user', 'sponsor'])->findOrFail($id);

        $total_installment = CommissionInstallment::where('order_id', $order->id)->where('status', 1)->sum('payment_amount');

        $installments = CommissionInstallment::where('order_id', $order->id)->cursor();

        return view('agent.orders.installment', compact('order', 'total_installment', 'installments'));
    }


    public function toCommissionUser($order_id)
    {

        $id = decrypt($order_id);

        $order = Order::with(['user', 'sponsor'])->findOrFail($id);

        $total_installment = CommissionInstallment::where('order_id', $order->id)->where('status', 1)->sum('payment_amount');

        $installments = CommissionInstallment::where('order_id', $order->id)->cursor();

        return view('user.orders.installment', compact('order', 'total_installment', 'installments'));
    }
}
