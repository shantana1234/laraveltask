<x-app-layout>
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                    @if($cartItems->count() > 0)
                        <span class="badge bg-primary">{{ $cartItems->count() }} items</span>
                    @endif
                </h2>
            </div>
        </div>

        @if($cartItems->count() > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th width="100">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product->images && count($item->product->images) > 0)
                                                            @php
                                                                $imageUrl = $item->product->images[0];
                                                                $imageSrc = filter_var($imageUrl, FILTER_VALIDATE_URL) 
                                                                    ? $imageUrl 
                                                                    : asset('storage/' . $imageUrl);
                                                            @endphp
                                                            <img src="{{ $imageSrc }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                            <small class="text-muted">{{ $item->product->category->name }}</small>
                                                            <br>
                                                            <small class="text-muted">Stock: {{ $item->product->stock }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    @if($item->product->isOnSale())
                                                        <span class="fw-bold text-danger">${{ number_format($item->product->sale_price, 2) }}</span>
                                                        <br><small class="text-muted text-decoration-line-through">${{ number_format($item->product->price, 2) }}</small>
                                                    @else
                                                        <span class="fw-bold">${{ number_format($item->product->price, 2) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="input-group" style="width: 120px;">
                                                            <input type="number" class="form-control form-control-sm text-center" 
                                                                   name="quantity" value="{{ $item->quantity }}" 
                                                                   min="1" max="{{ $item->product->stock }}" 
                                                                   onchange="this.form.submit()">
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="fw-bold">${{ number_format($item->getSubtotal(), 2) }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                                onclick="return confirm('Remove this item from cart?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Continue Shopping
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">Items ({{ $cartItems->count() }}):</div>
                                <div class="col-auto">${{ number_format($cartItems->sum(function($item) { return $item->getSubtotal(); }), 2) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">Shipping:</div>
                                <div class="col-auto">Free</div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col"><strong>Total:</strong></div>
                                <div class="col-auto"><strong class="text-primary">${{ number_format($total, 2) }}</strong></div>
                            </div>
                            
                            <div class="d-grid">
                                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                        <h3 class="text-muted">Your cart is empty</h3>
                        <p class="text-muted">Add some products to your cart to get started</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-1"></i>Browse Products
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 