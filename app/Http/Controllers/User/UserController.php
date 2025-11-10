<?php

namespace App\Http\Controllers\User;

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
            'image' => 'nullable'
        ]);

        $user->update($request->only([
            'name',
            'email',
            'phone',
            'phone_2',
            'state',
            'city',
            'address'
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
            'pancard' => 'required'
        ]);

        $user = Auth::user();
        $user->pancard = $request->pancard;
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
        $user->save();

        return back()->with(['success', 'Bank Details Updated Successfully ✅',  'active_tab' => 'card7-contact']);
    }




    function toproducts()
    {
        $products = Product::with(['category'])->cursor();
        return view('user.product.products', compact('products'));
    }
}
