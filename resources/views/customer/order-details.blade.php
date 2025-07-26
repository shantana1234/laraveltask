<x-app-layout>
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.orders') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
                    </ol>
                </nav>
                
                <h2 class="mb-4">
                    <i class="fas fa-receipt me-2"></i>Order Details
                    <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} ms-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </h2>
            </div>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Order Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y g:i A') }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Amount:</strong> <span class="text-primary">${{ number_format($order->total_amount, 2) }}</span></p>
                                <p><strong>Items:</strong> {{ $order->orderItems->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-box me-2"></i>Order Items
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->images && count($item->product->images) > 0)
                                                        @php
                                                            $imageUrl = $item->product->images[0];
                                                            $imageSrc = filter_var($imageUrl, FILTER_VALIDATE_URL) 
                                                                ? $imageUrl 
                                                                : asset('storage/' . $imageUrl);
                                                        @endphp
                                                        <img src="{{ $imageSrc }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Product Not Found' }}</h6>
                                                        @if($item->product)
                                                            <small class="text-muted">{{ $item->product->category->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td><strong>${{ number_format($item->getSubtotal(), 2) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-shipping-fast me-2"></i>Shipping Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>{{ $order->shipping_name }}</strong></p>
                        <p>{{ $order->shipping_email }}</p>
                        <p>{{ $order->shipping_phone }}</p>
                        <hr>
                        <p class="mb-1">{{ $order->shipping_address }}</p>
                        <p class="mb-0">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calculator me-2"></i>Order Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($order->orderItems->sum(function($item) { return $item->getSubtotal(); }), 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span>$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong class="text-primary">${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Orders
                            </a>
                            @if($order->status !== 'cancelled')
                                <button class="btn btn-outline-primary" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>Print Order
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 