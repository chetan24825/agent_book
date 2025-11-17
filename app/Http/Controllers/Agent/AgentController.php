<?php

namespace App\Http\Controllers\Agent;

use App\Models\User;
use App\Models\Orders\Order;

use Illuminate\Http\Request;
use App\Models\Inc\Withdrawal;
use App\Models\Product\Product;
use App\Models\Orders\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Orders\CommissionInstallment;

class AgentController extends Controller
{
    function toAgentLogin()
    {
        return view('agent.auth.login');
    }

    function toproducts()
    {
        $products = Product::with(['category'])->cursor();
        return view('agent.product.products', compact('products'));
    }

    function toAgentLoginPost(Request $request)
    {
        // Validate the email and password fields
        $request->validate([
            'email' => 'required|email|exists:agents,email',
            'password' => 'required|min:3',
        ]);

        // Prepare the credentials
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Attempt login
        if (Auth::guard('agent')->attempt($credentials)) {
            return redirect()->route('agent.dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials.');
        }
    }

    public function toAgentDashboard()
    {
        return view('agent.home.dashboard');
    }

    function toAgentprofile()
    {
        return view('agent.form.profile');
    }


    public function toAgentprofileUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . Auth::id(),
            'phone' => 'required|numeric|digits:10',
            'phone_2' => 'nullable|numeric|digits:10',
            'avatar' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'agent_code' => 'nullable|unique:agents,agent_code,' . Auth::id() . ',id',
        ]);

        auth()->user()->update($validatedData);

        return back()->with([
            'success' => 'Profile Updated Successfully ✅',
            'active_tab' => 'profile'
        ]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with([
            'success' => 'Password Updated Successfully ✅',
            'active_tab' => 'password'
        ]);
    }


    // ✅ KYC Upload
    public function updateKyc(Request $request)
    {
        $request->validate([
            'pancard' => 'required'
        ]);

        $user = Auth::user();
        $user->pancard = $request->pancard;
        $user->save();

        return back()->with([
            'success' => 'KYC Updated Successfully ✅',
            'active_tab' => 'kycTab'
        ]);
    }


    // ✅ Update Bank Details
    public function updateBankDetails(Request $request)
    {
        $request->validate([
            'account_holder_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required|same:confirm_account_number',
            'ifsc_code' => 'required',
            'account_type' => 'required',
            'check_image' => 'required'
        ]);

        $user = Auth::user();
        $user->account_name = $request->account_holder_name;
        $user->bank_name = $request->bank_name;
        $user->account_number = $request->account_number;
        $user->ifsc_code = $request->ifsc_code;
        $user->account_type = $request->account_type;
        $user->check_image = $request->check_image;
        $user->save();

        return back()->with([
            'success' => 'Bank Details Updated Successfully ✅',
            'active_tab' => 'bankTab'
        ]);
    }



    public function Cartdetail()
    {
        $users = User::orderBy('name')
            ->where('sponsor_id', Auth::guard(current_guard())->id()) // ✅ correct id()
            ->where('guard', current_guard())                         // ✅ filter by guard correctly
            ->cursor();

        return view('agent.product.cart', compact('users'));
    }

    public function toCheck(Request $request)
    {
        // ✅ Validate Form Request
        $request->validate([
            'checkout_user_id'   => 'required|exists:users,id',
            'checkout_user_guard' => 'required',
            'payment_amount' => 'required|numeric|gt:0'
        ]);

        // ✅ Get Cart
        $cart = session()->get('cart', []);

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Your cart is empty!');
        }

        // ✅ Fetch Selected User
        $user = User::findOrFail($request->checkout_user_id);

        // ✅ Calculate Total Amount
        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // ✅ Create Unique Order ID
        $customOrderId = 'ODR' . now()->format('YmdHis');

        // ✅ Create Order
        $order = Order::create([
            'user_id'             => $user->id,
            'guard'               => 'web', // ✅ Use passed guard
            'total_amount'        => $totalAmount,
            'payment_status'      => 'pending',
            'order_status'        => 'pending',
            'commission_user_id'  => $user->sponsor_id ?? Auth::guard(current_guard())->id(),   // Commission Receiver
            'commission_guard'     => $user->guard ?? current_guard(),
            'custom_order_id'     => $customOrderId,
            'order_by'            => current_guard() // agent ordering on behalf
        ]);

        // ✅ Insert Order Items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['product_id'],
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
                'total'        => $item['price'] * $item['quantity'],
            ]);
        }

        $previousPaid = CommissionInstallment::where('order_id', $order->id)->sum('payment_amount');
        $remaining = $order->total_amount - ($previousPaid + $request->payment_amount);

        CommissionInstallment::create([
            'order_id'       => $order->id,
            'user_id'        => $order->user_id ?? null,
            'user_guard'     => $order->guard,
            'payment_amount' => $request->payment_amount,
            'payment_remain' => $remaining,
            'remarks'        => $request->remarks ?? null,
            'status'        => 0,
        ]);

        // ✅ Clear cart
        session()->forget('cart');

        return redirect()->route('agent.thankyou')->with('success', 'Order placed successfully!');
    }



    public function toorders()
    {
        $orders = Order::with(['user', 'sponsor'])
            ->where('commission_user_id', Auth::guard(current_guard())->id())
            ->where('commission_guard', current_guard())
            ->orderBy('id', 'DESC')
            ->cursor();

        return view('agent.orders.orders', compact('orders'));
    }


    public function wallet()
    {
        $withdrawal = Withdrawal::where('user_id', Auth::guard(current_guard())->id())->where('user_guard', current_guard())->cursor();
        return view('agent.wallets.wallet', compact('withdrawal'));
    }


    public function Userwithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|max:' . Auth::guard(current_guard())->user()->commission,
        ], [
            'amount.max' => 'You do not have sufficient balance to withdraw this amount.',
        ]);

        $requestedAmount = (float) $request->amount;

        if (Withdrawal::where('user_id', Auth::guard(current_guard())->id())->where('user_guard', current_guard())->where('status', 0)->count() > 0) {
            return redirect()->back()->withInput()->with('warning', 'Your withdrawal request is pending.');
        }
        try {
            $withdrawal = new Withdrawal();
            $withdrawal->transaction_id = 'WD' . now()->format('YmdHis');
            $withdrawal->user_id = Auth::user()->id;
            $withdrawal->user_guard = current_guard();
            $withdrawal->amount = $requestedAmount;
            $withdrawal->balance_amount = Auth::guard(current_guard())->user()->commission;
            $withdrawal->save();
            return redirect()->back()->with('success', 'Your withdrawal request has been submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    function toThankyou()
    {
        return view('agent.product.thankyou');
    }
}
