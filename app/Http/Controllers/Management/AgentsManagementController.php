<?php

namespace App\Http\Controllers\Management;

use App\Models\Role\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class AgentsManagementController extends Controller
{

    function toagents(Request $request)
    {
        $query = Agent::query(); // Query builder initialize

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $agents = $query->paginate(50);

        return view('admin.management.agents.agents', compact('agents'));
    }



    public function AgentSave(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:agents,email',
            'password' => 'required|min:6',
            'phone' => 'required|integer|digits:10',
        ]);

        $agentCode = $this->generateUniqueAgentCode($request->name);
        // $agentCode = 'AG' . now()->format('YmdHis');

        // Create a new agent
        $agent = new Agent();
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->password = Hash::make($request->password);
        $agent->agent_code = $agentCode;
        $agent->status = $request->status;
        $agent->avatar = $request->avatar;
        $agent->address = $request->address;
        $agent->phone = $request->phone;
        $agent->phone_2 = $request->phone_2;
        $agent->save();

        return redirect()->back()->with('success', 'Agent created successfully.');
    }

    private function generateUniqueAgentCode($name)
    {
        $baseCode = strtolower(substr($name, 0, 3));
        do {
            $code = $baseCode . strtolower((string) random_int(100, 999));
        } while (Agent::where('agent_code', $code)->exists());

        return $code;
    }

    function toagentview($id)
    {
        $client = Agent::find($id);
        if ($client) {
            Auth::guard('agent')->login($client);
            return redirect()->route('agent.dashboard');
        }
    }

    function toagentnew()
    {
        return view('admin.management.agents.agents-new');
    }



    public function AgentDelete($id)
    {

        $agent = Agent::findOrFail($id);
        if ($agent->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    function toagentshow($id)
    {
        $user = Agent::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        return view('admin.management.agents.agent-edit', compact('user'));
    }



    public function toAgentprofileUpdate(Request $request)
    {

        $validatedData = $request->validate([
            'id' => 'required|exists:agents,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $request->id,
            'phone' => 'required|numeric|digits:10',
            'phone_2' => 'nullable|numeric|digits:10',
            'avatar' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'agent_code' => 'nullable|unique:agents,agent_code,' . $request->id . ',id',
        ]);

        $agent = Agent::findOrFail($request->id);
        $agent->update($validatedData);


        return back()->with([
            'success' => 'Profile Updated Successfully ✅',
            'active_tab' => 'profile'
        ]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed',
            'id' => 'required|exists:agents,id',
        ]);

        $user = Agent::findOrFail($request->id);
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
            'pancard' => 'required',
            'id' => 'required|exists:agents,id',
        ]);

        $user =  Agent::findOrFail($request->id);
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
            'id' => 'required|exists:agents,id',
            'account_holder_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required|same:confirm_account_number',
            'ifsc_code' => 'required',
            'account_type' => 'required',
            'check_image' => 'required'
        ]);

        $user = Agent::findOrFail($request->id);
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

    public function toVerify(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'id' => 'required|exists:agents,id',
            'admin_verification_status' => 'required|in:0,1',
            'status' => 'required|in:0,1,2', // 0=Banned, 1=Active, 2=Pending (optional)
        ]);

        // ✅ Find the agent safely
        $agent = Agent::findOrFail($validated['id']);

        // ✅ Update both statuses
        $agent->admin_verification_status = $validated['admin_verification_status'];
        $agent->status = $validated['status'];
        $agent->save();




        // ✅ Return with success message
        return back()->with([
            'success' => 'Agent verification updated successfully ✅',
            'active_tab' => 'adminVerify',
        ]);
    }
}
