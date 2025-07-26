<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class DashboardController extends Controller
{
    public function index()
    {
        // Monthly statistics
        $currentMonth = Carbon::now()->startOfMonth();
        
        $monthlyOrders = Order::where('created_at', '>=', $currentMonth)->count();
        $monthlySales = Order::where('created_at', '>=', $currentMonth)->sum('total_amount');
        
        // Top 5 selling products
        $topProducts = Product::whereHas('orderItems')
            ->withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->take(5)
            ->get();
        
        // Recent orders
        $recentOrders = Order::with(['user', 'orderItems'])
            ->latest()
            ->take(10)
            ->get();
        
        // Statistics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCustomers = User::role('customer')->count();
        $totalOrders = Order::count();
        
        return view('admin.dashboard', compact(
            'monthlyOrders', 
            'monthlySales', 
            'topProducts', 
            'recentOrders',
            'totalProducts',
            'totalCategories', 
            'totalCustomers',
            'totalOrders'
        ));
    }
    
    public function reports(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);
        
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        if ($request->filled('product_id')) {
            $query->whereHas('orderItems', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }
        
        if ($request->filled('customer_id')) {
            $query->where('user_id', $request->customer_id);
        }
        
        $orders = $query->get();
        
        $totalOrders = $orders->count();
        $totalSales = $orders->sum('total_amount');
        
        // Product-wise sales
        $productSales = collect();
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $productId = $item->product_id;
                if ($productSales->has($productId)) {
                    $productSales[$productId]['quantity'] += $item->quantity;
                    $productSales[$productId]['total'] += $item->getSubtotal();
                } else {
                    $productSales[$productId] = [
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                        'total' => $item->getSubtotal()
                    ];
                }
            }
        }
        
        // Customer-wise sales
        $customerSales = $orders->groupBy('user_id')->map(function ($orders, $userId) {
            return [
                'customer' => $orders->first()->user,
                'total_orders' => $orders->count(),
                'total_spent' => $orders->sum('total_amount')
            ];
        });
        
        $products = Product::all();
        $customers = User::role('customer')->get();
        
        return view('admin.reports', compact(
            'orders', 
            'totalOrders', 
            'totalSales', 
            'productSales', 
            'customerSales',
            'products',
            'customers'
        ));
    }
    
    public function exportReports(Request $request)
    {
        $format = $request->get('format', 'excel');
        
        if ($format === 'pdf') {
            // Return PDF view for printing
            return $this->reports($request);
        }
        
        return Excel::download(new ReportsExport($request->all()), 'reports.' . $format);
    }
}
