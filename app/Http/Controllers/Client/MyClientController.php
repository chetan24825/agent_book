<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyClientController extends Controller
{
    function toClientStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:my_clients,email',
            'phone' => 'required|string',
        ]);

        $my_clients = new User();
        $my_clients->name = $request->name;
        $my_clients->email = $request->email;
        $my_clients->phone = $request->phone;
        $my_clients->guard = current_guard();
        $my_clients->user_id = $request->user_id;


        $my_clients->phone_2 = $request->phone_2;
        $my_clients->avatar = $request->avatar;
        $my_clients->address = $request->address;
        $my_clients->save();

        return redirect()->back()->with('success', 'Client added successfully!');
    }



    function toclients(Request $request)
    {
        $query = User::where('user_id', Auth::user()->id)
            ->where('guard', current_guard());

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $myclients = $query->orderBy('id', 'DESC')->paginate(15);
        return view('agent.clients.ourclient', compact('myclients'));
    }

    function tonewclients()
    {
        return view('agent.clients.add-client');
    }

    function toClientupdate(Request $request, $id)
    {
        $client = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:my_clients,email,' . $id,
            'phone' => 'required|string|max:20',
            'status' => 'required|in:0,1',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable',
        ]);

        $client->update($validated);

        return redirect()->back()->with('success', 'Client updated successfully!');
    }

    function toClientDelete($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            return response()->json(['success' => true]);
        }
        // Fallback response if deletion fails
        return response()->json(['success' => false]);
    }
}
