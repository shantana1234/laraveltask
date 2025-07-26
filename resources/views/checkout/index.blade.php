<x-app-layout>
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-credit-card me-2"></i>Checkout
                </h2>
            </div>
        </div>

        <form action="{{ route('order.place') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <!-- Shipping Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-shipping-fast me-2"></i>Shipping Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="shipping_name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('shipping_name') is-invalid @enderror" 
                                           id="shipping_name" name="shipping_name" 
                                           value="{{ old('shipping_name', auth()->user()->name) }}" required>
                                    @error('shipping_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('shipping_email') is-invalid @enderror" 
                                           id="shipping_email" name="shipping_email" 
                                           value="{{ old('shipping_email', auth()->user()->email) }}" required>
                                    @error('shipping_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control @error('shipping_phone') is-invalid @enderror" 
                                           id="shipping_phone" name="shipping_phone" 
                                           value="{{ old('shipping_phone', auth()->user()->phone) }}" required>
                                    @error('shipping_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_city" class="form-label">City *</label>
                                    <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" 
                                           id="shipping_city" name="shipping_city" 
                                           value="{{ old('shipping_city') }}" required>
                                    @error('shipping_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="shipping_address" class="form-label">Street Address *</label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                              id="shipping_address" name="shipping_address" 
                                              rows="3" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_state" class="form-label">State/Province *</label>
                                    <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" 
                                           id="shipping_state" name="shipping_state" 
                                           value="{{ old('shipping_state') }}" required>
                                    @error('shipping_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_zip" class="form-label">ZIP/Postal Code *</label>
                                    <input type="text" class="form-control @error('shipping_zip') is-invalid @enderror" 
                                           id="shipping_zip" name="shipping_zip" 
                                           value="{{ old('shipping_zip') }}" required>
                                    @error('shipping_zip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-credit-card me-2"></i>Payment Method
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                This is a demo store. Payment processing is simulated. Your order will be processed upon submission.
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="cod" checked>
                                <label class="form-check-label" for="cash_on_delivery">
                                    <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            @foreach($cartItems as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                                        <small class="text-muted">Qty: {{ $item->quantity }} × ${{ number_format($item->product->getCurrentPrice(), 2) }}</small>
                                    </div>
                                    <span class="fw-bold">${{ number_format($item->getSubtotal(), 2) }}</span>
                                </div>
                            @endforeach
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($cartItems->sum(function($item) { return $item->getSubtotal(); }), 2) }}</span>
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
                            
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong class="text-primary">${{ number_format($total, 2) }}</strong>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check me-2"></i>Place Order
                                </button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout> 