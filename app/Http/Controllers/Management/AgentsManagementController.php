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

    public function AgentUpdate(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|digits:10',
            'address' => 'required',
        ]);
        $agent = Agent::find($id);
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->status = $request->status;
        $agent->phone = $request->phone;
        $agent->address = $request->address;
        $agent->phone_2 = $request->phone_2;
        $agent->save();

        return redirect()->back()->with('success', 'Agent updated successfully!');
    }

    public function AgentDelete($id)
    {

        $agent = Agent::findOrFail($id);
        if ($agent->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
