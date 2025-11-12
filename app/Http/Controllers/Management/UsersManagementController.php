<?php

namespace App\Http\Controllers\Management;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersManagementController extends Controller
{

    public function updateProfile(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $request->id,

            'phone' => 'required',
            'phone_2' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable',
            'shop_name' => 'required'
        ]);

        $user = User::findOrFail($request->id);
        $user->update($request->only([
            'name',
            'email',
            'phone',
            'phone_2',
            'state',
            'city',
            'address',
            'shop_name'
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
            'id' => 'required|exists:users,id',
            'new_password' => 'required|min:2|confirmed'
        ]);

        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with(['success', 'Password Updated Successfully ✅', 'active_tab' => 'card7-password']);
    }


    // ✅ KYC Upload
    public function updateKyc(Request $request)
    {
        $request->validate([
            'pancard' => 'required',
            'id' => 'required|exists:users,id',

        ]);

        $user = User::findOrFail($request->id);
        $user->pancard = $request->pancard;
        $user->save();

        return back()->with(['success', 'KYC Updated Successfully ✅',  'active_tab' => 'card7-profile']);
    }


    // ✅ Update Bank Details
    public function updateBankDetails(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',

            'account_holder_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required|same:confirm_account_number',
            'ifsc_code' => 'required',
            'account_type' => 'required',
            'check_image' => 'required'
        ]);

        $user = User::findOrFail($request->id);
        $user->account_name = $request->account_holder_name;
        $user->bank_name = $request->bank_name;
        $user->account_number = $request->account_number;
        $user->ifsc_code = $request->ifsc_code;
        $user->account_type = $request->account_type;
        $user->check_image = $request->check_image; // AIZUploader stored path
        $user->save();

        return back()->with(['success', 'Bank Details Updated Successfully ✅',  'active_tab' => 'card7-contact']);
    }

     public function toVerify(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'admin_verification_status' => 'required|in:0,1',
            'status' => 'required|in:0,1,2', // 0=Banned, 1=Active, 2=Pending (optional)
        ]);

        // ✅ Find the agent safely
        $agent = User::findOrFail($validated['id']);

        // ✅ Update both statuses
        $agent->admin_verification_status = $validated['admin_verification_status'];
        $agent->status = $validated['status'];
        $agent->save();




        // ✅ Return with success message
        return back()->with([
            'success' => 'User verification updated successfully ✅',
            'active_tab' => 'adminVerify',
        ]);
    }
}
