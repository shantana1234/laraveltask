<x-app-layout>
    <div class="container my-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6">
                <div class="card">
                    @if($product->images && count($product->images) > 0)
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                    @php
                                        // Check if it's an external URL or local storage
                                        $imageSrc = filter_var($image, FILTER_VALIDATE_URL) 
                                            ? $image 
                                            : asset('storage/' . $image);
                                    @endphp
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ $imageSrc }}" 
                                             class="d-block w-100" alt="{{ $product->name }}" 
                                             style="height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($product->images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            <i class="fas fa-image fa-5x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">{{ $product->name }}</h1>
                        <p class="text-muted mb-3">
                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }} | 
                            <i class="fas fa-barcode me-1"></i>SKU: {{ $product->sku }}
                        </p>

                        <!-- Price -->
                        <div class="mb-3">
                            @if($product->isOnSale())
                                <span class="h3 text-danger">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="h5 text-muted text-decoration-line-through ms-2">${{ number_format($product->price, 2) }}</span>
                                <span class="badge bg-danger ms-2">
                                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                                </span>
                            @else
                                <span class="h3">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-3">
                            @if($product->stock > 0)
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>In Stock ({{ $product->stock }} available)
                                </span>
                                @if($product->stock <= 5)
                                    <span class="badge bg-warning ms-2">Low Stock</span>
                                @endif
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times me-1"></i>Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>

                        <!-- Add to Cart -->
                        @auth
                            @if(!auth()->user()->isAdmin() && $product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-3">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-4">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                                   value="1" min="1" max="{{ $product->stock }}" required>
                                        </div>
                                        <div class="col-8 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div class="d-grid">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Purchase
                                </a>
                            </div>
                        @endauth

                        <!-- Additional Actions -->
                        <div class="d-grid">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Related Products</h3>
                    <div class="row">
                        @foreach($relatedProducts as $related)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    @if($related->images && count($related->images) > 0)
                                        @php
                                            $imageUrl = $related->images[0];
                                            $imageSrc = filter_var($imageUrl, FILTER_VALIDATE_URL) 
                                                ? $imageUrl 
                                                : asset('storage/' . $imageUrl);
                                        @endphp
                                        <img src="{{ $imageSrc }}" 
                                             class="card-img-top" alt="{{ $related->name }}" 
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title">{{ $related->name }}</h6>
                                        <p class="card-text flex-grow-1">{{ Str::limit($related->description, 60) }}</p>
                                        <div class="mt-auto">
                                            <div class="mb-2">
                                                @if($related->isOnSale())
                                                    <span class="fw-bold text-danger">${{ number_format($related->sale_price, 2) }}</span>
                                                    <small class="text-muted text-decoration-line-through">${{ number_format($related->price, 2) }}</small>
                                                @else
                                                    <span class="fw-bold">${{ number_format($related->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <a href="{{ route('products.show', $related) }}" class="btn btn-outline-primary btn-sm">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 