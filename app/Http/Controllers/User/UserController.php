<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Role\Agent;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function toUserDashboard()
    {
        return view('user.home.dashboard');
    }

    function toOrderView($order_id)
    {
        $id = decrypt($order_id);
        $order = Order::with('items')->findOrFail($id);
        return view('user.orders.view', compact('order'));
    }

    public function UserProfile()
    {
        $profile = Auth::user();
        return view('user.profile.profile', compact('profile')); // Change to user profile view
    }


    public function updateProfile(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,

            'phone' => 'required',
            'phone_2' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable',
            'shop_name' => 'required',
            'shop_address'=>'nullable'
        ]);

        $user->update($request->only([
            'name',
            'email',
            'phone',
            'phone_2',
            'state',
            'city',
            'address',
            'shop_name',
            'shop_address'
        ]));

        if ($request->image) {
            $user->avatar = $request->image; // because AIZUploader stores file path
            $user->save();
        }

        return back()->with(['success', 'Profile Updated Successfully ✅', 'active_tab' => 'card7-home']);
    }


    // ✅ Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:2|confirmed'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with(['success', 'Password Updated Successfully ✅', 'active_tab' => 'card7-password']);
    }


    // ✅ KYC Upload
    public function updateKyc(Request $request)
    {
        $request->validate([
            'pancard' => 'required',
            'aadhar_card' => 'required'

        ]);

        $user = Auth::user();
        $user->pancard = $request->pancard;
        $user->aadhar_card = $request->aadhar_card ?? null;
        $user->save();

        return back()->with(['success', 'KYC Updated Successfully ✅',  'active_tab' => 'card7-profile']);
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
        $user->check_image = $request->check_image; // AIZUploader stored path
        $user->gst_number = $request->gst_number;
        $user->save();

        return back()->with(['success', 'Bank Details Updated Successfully ✅',  'active_tab' => 'card7-contact']);
    }




    function toproducts()
    {
        $products = Product::with(['category'])->cursor();
        return view('user.product.products', compact('products'));
    }

    function Cartdetail()
    {
        return view('user.product.cart');
    }

    public function toOrder()
    {
        $orders = Order::with(['user', 'sponsor'])
            ->where('user_id', Auth::guard(current_guard())->id())
            ->orderBy('id', 'DESC')
            ->cursor();

        return view('user.orders.orders', compact('orders'));
    }


    function invoice($id)
    {
        $order = Order::with('items', 'user', 'sponsor')
            ->where('user_id', Auth::guard(current_guard())->id())
            ->findOrFail($id);
        return view('user.orders.invoice', compact('order'));
    }


    function toLogin()
    {
        return view('user.auth.login');
    }

    function toregister()
    {
        return view('user.auth.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|numeric|digits:10|unique:users,phone',
            'password'   => 'required|min:3|confirmed',
            'sponsor_id' => 'required|exists:agents,agent_code',
        ]);

        // Fetch sponsor user
        $sponsor = Agent::where('agent_code', $request->sponsor_id)->first();

        if (!$sponsor) {
            return back()->with('error', 'Invalid Sponsor ID')->withInput();
        }

        // Create new user
        $user = new User();
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        $user->password  = Hash::make($request->password);
        $user->sponsor_id = $sponsor->id;  // Sponsor reference
        $user->save();

        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }


    public function checkSponsor(Request $request)
    {
        $request->validate(['sponsor_id' => 'required']);

        $user = Agent::where('agent_code', $request->sponsor_id)->first();

        if ($user) {
            return response()->json([
                'status' => true,
                'name' => $user->name
            ]);
        }

        return response()->json(['status' => false]);
    }


    public function toLoginPost(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        // ✅ Attempt login with web guard
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate(); // prevent session fixation

            return redirect()->route('user.dashboard')
                ->with('success', 'Welcome back!');
        }

        // ❌ Invalid credentials
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password.');
    }
}
