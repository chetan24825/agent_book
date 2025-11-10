<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use App\Models\Inc\Notification;
use App\Models\Inc\YoutubeVideo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Packages\Package;
use App\Models\Product\Product;

class BasicController extends Controller
{

    function toLogout()
    {
        Auth::guard(current_guard())->logout();
        request()->session()->invalidate(); // Invalidate the session
        request()->session()->regenerateToken(); // Regenerate the CSRF token for security
        return redirect()->route('site.index');
    }


    public function Notifications()
    {
        $guard = null;
        $prefix = null;
        if (Auth::guard(current_guard())->check()) {
            $prefix = 'admin.layouts.app';
            if (current_guard() == 'admin') {
                $prefix = 'admin.layouts.app';
            }
            if (current_guard() == 'advertiser') {
                $prefix = 'advertisers.layouts.app';
            }
            if (current_guard() == 'agent') {
                $prefix = 'agent.layouts.app';
            }
        }
        $notifications = Notification::where('user_id', Auth::id())
            ->where('guard', current_guard())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notification.notification', compact('notifications', 'prefix'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ]);
        // Fetch product
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'status'  => false,
                'message' => 'Product not found!',
            ], 404);
        }

        // Get existing cart
        $cart = session()->get('cart', []);

        $product_id = $product->id;

        // If product already exists in cart, update quantity
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $request->quantity;
        } else {
            // Add new item to cart
            $cart[$product_id] = [
                'product_id' => $product_id,
                'quantity'   => $request->quantity,
                'user_id'    => Auth::guard(current_guard())->id(),
                'guard'      => current_guard(),
                'price'      => $product->sale_price ?? $product->mrp_price,
                'name'       => $product->product_name,
                'image'      => $product->thumbphotos ?? null,
            ];
        }

        // Save updated cart to session
        session()->put('cart', $cart);

        return response()->json([
            'status'  => true,
            'message' => 'Product added to cart successfully.',
            'cart'    => $cart,
            'count'   => count($cart),
        ]);
    }


    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return  redirect()->back()->with('success', 'Product Remove to cart successfully.');
    }

    public function updateCart($id, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Get cart from session
        $cart = session()->get('cart', []);

        // Check if product exists in cart
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int)$request->quantity;

            // Update total price for that item if you store total
            $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
        }

        // Save updated cart back into session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }
}
