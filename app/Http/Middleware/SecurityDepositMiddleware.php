<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Inc\SecurityDeposit;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SecurityDepositMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard(current_guard())->user();
        $deposit = SecurityDeposit::where('agent_id', $user->id)
            ->where('status', 1)             // approved
            ->where('is_refundable', 0)        // not refunded yet
            ->where('amount', '>', 0)
            ->first();

        if (!$deposit) {
            return redirect()->route('agent.security')->with('warning', "You need to submit security first.");
        }

        return $next($request);
    }
}
