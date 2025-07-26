<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($u) use ($request) {
                      $u->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $orders = $query->latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order->update(['status' => $request->status]);
        
        return back()->with('success', 'Order status updated successfully!');
    }
    
    public function generateInvoice(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        
        $pdf = Pdf::loadView('admin.orders.invoice', compact('order'));
        
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }
    
    public function customers(Request $request)
    {
        $query = User::role('customer')->withCount('orders');
        
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $customers = $query->paginate(15);
        
        return view('admin.customers.index', compact('customers'));
    }
    
    public function customerDetails(User $user)
    {
        $user->load(['orders.orderItems.product']);
        
        // Customer statistics
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->sum('total_amount');
        
        // Recent orders
        $recentOrders = $user->orders()->latest()->take(10)->get();
        
        return view('admin.customers.show', compact('user', 'totalOrders', 'totalSpent', 'recentOrders'));
    }
}
