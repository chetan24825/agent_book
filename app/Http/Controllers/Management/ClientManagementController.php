<?php

namespace App\Http\Controllers\Management;

use App\Models\Inc\Store;
use Illuminate\Http\Request;
use App\Models\Role\MyClient;
use App\Models\Product\Product;
use App\Models\Role\Advertiser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientManagementController extends Controller
{

    function toclients(Request $request)
    {
        $query = Advertiser::with(['store']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
                // Search by date (if input is a valid date)
                if (strtotime($search)) {
                    $date = date('Y-m-d', strtotime($search)); // Convert user input date
                    $q->orWhereDate('created_at', $date);
                }
            })->orWhereHas('store', function ($q) use ($search) {
                $q->where('store_name', 'LIKE', "%{$search}%");
            });;
        }

        $clients = $query->paginate(50);
        return view('admin.management.clients.clients', compact('clients'));
    }




    function toadvertiserclients(Request $request)
    {

        $query = MyClient::with('advertiser');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $myclients = $query->orderBy('id', 'DESC')->paginate(15);

        return view('admin.management.clients.ourclient',compact('myclients'));
    }




    function toclientview($id)
    {
        $client = Advertiser::find($id);
        if ($client) {
            Auth::guard('advertiser')->login($client);
            return redirect()->route('advertiser.dashboard');
        }
    }
    public function toggleStatus($storeId)
    {
        $store = Store::find($storeId);
        if ($store) {
            // Toggle the status
            $store->status = $store->status == 1 ? 0 : 1;
            $store->save();

            return response()->json([
                'success' => true,
                'new_status' => $store->status,
            ]);
        }

        return response()->json(['success' => false]);
    }
    public function ClientUpdate(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'required|digits:10|unique:advertisers,phone,' . $id, // Ignore current user ID for phone uniqueness
            'address' => 'nullable',
        ]);
        $client = Advertiser::find($id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->status = $request->status;
        $client->phone = $request->phone;
        $client->phone_2 = $request->phone_2;
        $client->agent_code = $request->agent_code;
        $client->agent_code_status = $request->agent_code_status;
        $client->address = $request->address;
        $client->save();

        // Check if a store exists for the client
        $store = Store::where('guard', 'advertiser')
            ->where('user_id', $client->id)
            ->first();

        if ($store) {
            $store->update([
                'status' => $request->status,
                'priority' => $request->priority,
            ]);
        }
        return redirect()->back()->with('success', 'Client updated successfully!');
    }

    public function ClientDelete($id)
    {
        $user = Advertiser::findOrFail($id);
        if ($user->delete()) {
            Store::where('guard', 'advertiser')->where('user_id', $id)->delete();
            Product::where('guard', 'advertiser')->where('user_id', $id)->delete();
            return response()->json(['success' => true]);
        }
        // Fallback response if deletion fails
        return response()->json(['success' => false]);
    }
}
