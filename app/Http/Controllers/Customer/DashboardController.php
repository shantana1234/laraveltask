<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();
        
        // Monthly statistics
        $currentMonth = Carbon::now()->startOfMonth();
        $monthlyOrders = Order::where('user_id', $user->id)
            ->where('created_at', '>=', $currentMonth)
            ->count();
        
        $monthlySpent = Order::where('user_id', $user->id)
            ->where('created_at', '>=', $currentMonth)
            ->sum('total_amount');
        
        // Top 5 purchased products
        $topProducts = Product::whereHas('orderItems.order', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->withSum(['orderItems as total_quantity' => function ($query) use ($user) {
            $query->whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }], 'quantity')
        ->orderBy('total_quantity', 'desc')
        ->take(5)
        ->get();
        
        // Recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        return view('customer.dashboard', compact('monthlyOrders', 'monthlySpent', 'topProducts', 'recentOrders'));
    }
    
    public function orders(Request $request)
    {
        $query = Order::where('user_id', Auth::id())->latest();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        $orders = $query->paginate(10);
        
        return view('customer.orders', compact('orders'));
    }
    
    public function orderDetails(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['orderItems.product']);
        
        return view('customer.order-details', compact('order'));
    }
    
    public function reports(Request $request)
    {
        $user = Auth::user();
        
        $query = Order::where('user_id', $user->id);
        
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        $orders = $query->with('orderItems.product')->get();
        
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total_amount');
        
        // Product-wise report
        $productStats = collect();
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $productId = $item->product_id;
                if ($productStats->has($productId)) {
                    $productStats[$productId]['quantity'] += $item->quantity;
                    $productStats[$productId]['total'] += $item->getSubtotal();
                } else {
                    $productStats[$productId] = [
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                        'total' => $item->getSubtotal()
                    ];
                }
            }
        }
        
        return view('customer.reports', compact('orders', 'totalOrders', 'totalSpent', 'productStats'));
    }
}
