<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MyClientController extends Controller
{


    public function toClientStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
        ]);

        DB::beginTransaction();

        try {

            $client = new User();
            $client->name       = $request->name;
            $client->email      = $request->email;
            $client->phone      = $request->phone;
            $client->phone_2    = $request->phone_2;
            $client->avatar     = $request->avatar;
            $client->address    = $request->address;
            $client->guard      = current_guard();
            $client->sponsor_id = Auth::id();
            $client->password = Hash::make(111);
            $client->status     = 1; // optional default active

            $client->save();

            DB::commit();
            return redirect()->back()->with('success', 'Client added successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Client Store Failed: ' . $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }




    function toclients(Request $request)
    {
        $query = User::where('sponsor_id', Auth::user()->id)
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
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            // 'status' => 'required|in:0,1',
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
