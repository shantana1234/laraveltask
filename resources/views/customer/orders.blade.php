<x-app-layout>
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-list me-2"></i>My Orders
                </h2>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('customer.orders') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="from_date" class="form-label">From Date</label>
                                    <input type="date" class="form-control datepicker" id="from_date" name="from_date" 
                                           value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="to_date" class="form-label">To Date</label>
                                    <input type="date" class="form-control datepicker" id="to_date" name="to_date" 
                                           value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="row">
            <div class="col-12">
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <h6 class="mb-0">Order #{{ $order->order_number }}</h6>
                                        <small class="text-muted">{{ $order->created_at->format('M d, Y g:i A') }}</small>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} fs-6">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <strong class="text-primary">${{ number_format($order->total_amount, 2) }}</strong>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="text-muted">{{ $order->orderItems->count() }} items</small>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-box-open fa-5x text-muted mb-3"></i>
                            <h3 class="text-muted">No orders found</h3>
                            @if(request()->hasAny(['status', 'from_date', 'to_date']))
                                <p class="text-muted">Try adjusting your filters</p>
                                <a href="{{ route('customer.orders') }}" class="btn btn-primary">Clear Filters</a>
                            @else
                                <p class="text-muted">You haven't placed any orders yet</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 