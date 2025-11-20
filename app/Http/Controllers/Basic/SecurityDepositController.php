<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use App\Models\Inc\SecurityDeposit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class SecurityDepositController extends Controller
{
    function topayment()
    {
        $security = SecurityDeposit::where('agent_id', Auth::guard(current_guard())->user()->id)
            ->where('guard', current_guard())
            ->latest()
            ->first();

        return view('agent.product.payment', compact('security'));
    }

    public function topaymentStore(Request $request)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:1',
            'utr_id'         => 'required|string|max:100',
            'payment_image'  => 'nullable|string',
        ]);

        SecurityDeposit::create([
            'agent_id'   => Auth::guard(current_guard())->id(),
            'guard'      => current_guard(),
            'amount'     => $request->payment_amount,
            'utr_id'     => $request->utr_id,
            'payment_image' => $request->payment_image,
            'status'     => 0,
        ]);

        return redirect()->back()->with('success', 'Security deposit submitted successfully.');
    }

    public function toPaymentRefund(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:security_deposits,id',
            'is_refundable_request' => 'required|in:1'
        ]);

        $security = SecurityDeposit::find($request->id);

        if (!$security) {
            return back()->with('error', 'Security deposit record not found.');
        }

        // Prevent duplicate refund requests
        if ($security->is_refundable == 1) {
            return back()->with('error', 'Refund already requested.');
        }

        $security->update([
            'is_refundable_request' => 1,   // Mark refund requested
            'is_refundable_request_date' => now()
        ]);

        return back()->with('success', 'Refund request submitted successfully.');
    }

    // -----------------------------------------------------------------------------------------
    // ------------------------------------ Admin ----------------------------------------------
    // -----------------------------------------------------------------------------------------

    function topaymentadmin()
    {
        $security = SecurityDeposit::with('user')->orderBy('id', 'DESC')->where('is_refundable_request', 0)->where('is_refundable', 0)->cursor();
        return view('admin.security.security', compact('security'));
    }

    public function updatepayment(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:security_deposits,id',
            'status' => 'required|in:0,1,2', // 0=pending,1=approved,2=rejected
        ]);

        $withdraw = SecurityDeposit::findOrFail($request->id);
        $withdraw->status = $request->status;
        $withdraw->save();

        return response()->json([
            'status' => true,
            'message' => $request->status == 1 ? 'Approved Successfully' : 'Rejected Successfully'
        ]);
    }

    function topaymentadminrefundupdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:security_deposits,id',
            'status' => 'required|in:3,2', // 3=approved,2=rejected
        ]);

        $withdraw = SecurityDeposit::findOrFail($request->id);

        if ($request->status == 2) { // Reject
            $withdraw->is_refundable_request = 0;
            $withdraw->is_refundable_request_date = null;
            $withdraw->status = 2;
        }

        if ($request->status == 3) { // Approve
            $withdraw->is_refundable = 1;
            $withdraw->is_refundable_date = now();
            $withdraw->status = 3;
        }

        $withdraw->save();

        return response()->json([
            'status' => true,
            'message' => $request->status == 3 ? 'Approved Successfully' : 'Rejected Successfully'
        ]);
    }

    function sendTopupMessage(Request $request)
    {
        $request->validate([
            "id" => "required|exists:security_deposits,id",
            "message" => "required|string|max:500",
        ]);

        $withdraw = SecurityDeposit::find($request->id);
        $withdraw->remarks = $request->message;
        $withdraw->save();

        return response()->json([
            "message" => "Topup Message sent successfully!"
        ]);
    }


    function topaymentadminrefund()
    {
        $security = SecurityDeposit::with('user')->orderBy('id', 'DESC')->where('is_refundable_request', 1)->where('is_refundable', 0)->cursor();
        return view('admin.security.refund', compact('security'));
    }

    function topaymenthistory()
    {
        $security = SecurityDeposit::with('user')->orderBy('id', 'DESC')->where('status', 3)->cursor();
        return view('admin.security.history', compact('security'));
    }
}
