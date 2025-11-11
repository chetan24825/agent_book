<?php

namespace App\Http\Controllers\Agent;

use App\Models\Orders\Order;
use Illuminate\Http\Request;

use App\Models\Inc\Withdrawal;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|min:6',
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

    function toAgentprofileUpdate(Request $request)
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

        if (auth()->user()->update($validatedData)) {
            return redirect()->back()->with('success', 'Updated successfully.');
        }
    }


    public function updatePassword(Request $request)
    {
        // Validate the password fields
        $request->validate([
            'password' => 'required|string|confirmed',
        ]);

        // Update the password
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect with success message
        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    function Cartdetail()
    {
        return view('agent.product.cart');
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
        $withdrawal = Withdrawal::where('user_id', Auth::user()->id)->get();
        return view('agent.wallet.wallet', compact('withdrawal'));
    }


    public function Userwithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|max:' . Auth::user()->balance,
        ], [
            'amount.max' => 'You do not have sufficient balance to withdraw this amount.',
        ]);

        $requestedAmount = (float) $request->amount;

        if (Withdrawal::where('user_id', Auth::id())->where('status', 0)->count() > 0) {
            return redirect()->back()->with('warning', 'Your withdrawal request is pending.');
        }
        try {
            $withdrawal = new Withdrawal();
            $withdrawal->transaction_id = 'WD' . now()->format('YmdHis');
            $withdrawal->user_id = Auth::user()->id;
            $withdrawal->amount = $requestedAmount;
            $withdrawal->balance_amount = (Auth::user()->balance);
            $withdrawal->save();
            return redirect()->back()->with('success', 'Your withdrawal request has been submitted successfully.');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred while processing your withdrawal request. Please try again later.');
        }
    }
}
