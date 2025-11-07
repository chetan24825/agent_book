<?php

namespace App\Http\Controllers\Management;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersManagementController extends Controller
{

    function tousers(Request $request)
{
    $query = User::with('favourites.store');

    // Check if search input is provided
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%")
              ->orWhere('status', 'LIKE', "%{$search}%")
              ->orWhere('state', 'LIKE', "%{$search}%")
              ->orWhere('city', 'LIKE', "%{$search}%");

            // Optional: You can add search for `favourites.store.store_name` if needed
            $q->orWhereHas('favourites.store', function ($q) use ($search) {
                $q->where('store_name', 'LIKE', "%{$search}%");
            });

            // Check if input is a valid date and filter by `created_at`
            if (strtotime($search)) {
                $date = date('Y-m-d', strtotime($search));
                $q->orWhereDate('created_at', $date);
            }
        });
    }

    // Paginate results
    $users = $query->paginate(50);

    return view('admin.management.users.users', compact('users'));
}


    public function UserUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'required|unique:users,phone,' . $id, // Ignore current user ID for phone uniqueness
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zip_code' => 'nullable|numeric',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->phone_2 = $request->phone_2;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->status = $request->status;
        $user->zip_code = $request->zip_code;
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully');
    }


    public function UserDelete($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }


    function touserview($id)
    {
        $client = User::find($id);
        if ($client) {
            Auth::guard('web')->login($client);
            return redirect()->route('user.dashboard');
        }
    }
}
