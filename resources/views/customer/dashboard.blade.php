<x-app-layout>
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-user-circle me-2"></i>Customer Dashboard
                    <small class="text-muted">Welcome back, {{ auth()->user()->name }}!</small>
                </h2>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $monthlyOrders }}</h4>
                                <p class="mb-0">Orders This Month</p>
                            </div>
                            <i class="fas fa-shopping-bag fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>${{ number_format($monthlySpent, 2) }}</h4>
                                <p class="mb-0">Spent This Month</p>
                            </div>
                            <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ auth()->user()->orders()->count() }}</h4>
                                <p class="mb-0">Total Orders</p>
                            </div>
                            <i class="fas fa-list fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>${{ number_format(auth()->user()->orders()->sum('total_amount'), 2) }}</h4>
                                <p class="mb-0">Total Spent</p>
                            </div>
                            <i class="fas fa-chart-line fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Orders -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>Recent Orders
                        </h5>
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                    <div class="card-body">
                        @if($recentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
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
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
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
                                <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No orders yet</h5>
                                <p class="text-muted">Start shopping to see your orders here</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>Your Top Products
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($topProducts->count() > 0)
                            @foreach($topProducts as $product)
                                <div class="d-flex align-items-center mb-3">
                                    @if($product->images && count($product->images) > 0)
                                        @php
                                            $imageUrl = $product->images[0];
                                            $imageSrc = filter_var($imageUrl, FILTER_VALIDATE_URL) 
                                                ? $imageUrl 
                                                : asset('storage/' . $imageUrl);
                                        @endphp
                                        <img src="{{ $imageSrc }}" 
                                             alt="{{ $product->name }}" 
                                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                        <small class="text-muted">
                                            Purchased {{ $product->total_quantity ?? 0 }} times
                                        </small>
                                    </div>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-star fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No purchases yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Browse Products
                            </a>
                            <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-2"></i>View All Orders
                            </a>
                            <a href="{{ route('customer.reports') }}" class="btn btn-outline-info">
                                <i class="fas fa-chart-bar me-2"></i>View Reports
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 