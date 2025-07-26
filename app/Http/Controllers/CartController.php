<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);
        
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();
        
        if ($existingCart) {
            $newQuantity = $existingCart->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Not enough stock available.');
            }
            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }
        
        return back()->with('success', 'Product added to cart successfully!');
    }
    
    public function update(Cart $cart, Request $request)
    {
        $this->authorize('update', $cart);
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart->product->stock
        ]);
        
        $cart->update(['quantity' => $request->quantity]);
        
        return back()->with('success', 'Cart updated successfully!');
    }
    
    public function remove(Cart $cart)
    {
        $this->authorize('delete', $cart);
        
        $cart->delete();
        
        return back()->with('success', 'Item removed from cart!');
    }
}
