<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use App\Models\Inc\Withdrawal;
use App\Http\Controllers\Controller;

class WithdrawalController extends Controller
{

    function topending()
    {
        $withdrawal = Withdrawal::with('user')->cursor();
        return view('admin.withdrawal.withdrawal', compact('withdrawal'));
    }



    function toview($id)
    {
        $withdrawal = Withdrawal::where('id', $id)->with('user')->first();
        return view('admin.withdrawal.withdral_status', compact('withdrawal'));
    }

    public function towithdrawalupdate(Request $request, $id)
    {
        try {
            // Retrieve the withdrawal record and associated user
            $withdrawal = Withdrawal::findOrFail($id)->load('user');
            $user = $withdrawal->user;

            if ($request->has('approve')) {
                // Calculate the new balance
                $newBalance = $user->commission - $withdrawal->amount;
                $withdrawal->balance_amount = $newBalance;
                $withdrawal->remark = $request->remark; // Approved

                $user->commission = $newBalance;
                $user->save();
            }

            // Update the withdrawal status based on the action
            $withdrawal->status = $request->has('approve') ? 1 : 2;

            $withdrawal->save();

            return redirect()->back()->with('success', 'Update Successfully');
        } catch (\Exception $e) {


            return redirect()->back()->with('error', 'An error occurred while updating the withdrawal. Please try again.' . $e->getMessage());
        }
    }
}
