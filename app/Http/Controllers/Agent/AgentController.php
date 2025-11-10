<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
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
}
