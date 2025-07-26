<x-admin-layout>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalProducts }}</h4>
                            <p class="mb-0">Total Products</p>
                        </div>
                        <i class="fas fa-box fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalOrders }}</h4>
                            <p class="mb-0">Total Orders</p>
                        </div>
                        <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalCustomers }}</h4>
                            <p class="mb-0">Total Customers</p>
                        </div>
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalCategories }}</h4>
                            <p class="mb-0">Categories</p>
                        </div>
                        <i class="fas fa-tags fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Stats -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">This Month</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h3 class="text-primary">{{ $monthlyOrders }}</h3>
                            <p class="text-muted">Orders</p>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success">${{ number_format($monthlySales, 2) }}</h3>
                            <p class="text-muted">Sales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Product
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add Category
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-list me-2"></i>View Orders
                        </a>
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-info">
                            <i class="fas fa-chart-bar me-2"></i>View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No orders yet</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 