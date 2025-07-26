<x-app-layout>
    <div class="container my-4">
        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="bg-primary text-white rounded p-5 text-center">
                    <h1 class="display-4 mb-3">Welcome to Our Store</h1>
                    <p class="lead">Discover amazing products at great prices</p>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#filters">
                                <i class="fas fa-filter me-2"></i>Filters & Search
                            </button>
                        </h5>
                    </div>
                    <div id="filters" class="collapse {{ request()->hasAny(['search', 'category', 'min_price', 'max_price']) ? 'show' : '' }}">
                        <div class="card-body">
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="search" class="form-label">Search Products</label>
                                        <input type="text" class="form-control" id="search" name="search" 
                                               value="{{ request('search') }}" placeholder="Search by name...">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select" id="category" name="category">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="min_price" class="form-label">Min Price</label>
                                        <input type="number" class="form-control" id="min_price" name="min_price" 
                                               value="{{ request('min_price') }}" placeholder="0" step="0.01">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="max_price" class="form-label">Max Price</label>
                                        <input type="number" class="form-control" id="max_price" name="max_price" 
                                               value="{{ request('max_price') }}" placeholder="1000" step="0.01">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-search me-1"></i>Filter
                                        </button>
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>Clear
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            @if($product->images && count($product->images) > 0)
                                @php
                                    $imageUrl = $product->images[0];
                                    // Check if it's an external URL or local storage
                                    $imageSrc = filter_var($imageUrl, FILTER_VALIDATE_URL) 
                                        ? $imageUrl 
                                        : asset('storage/' . $imageUrl);
                                @endphp
                                <img src="{{ $imageSrc }}" 
                                     class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            @if($product->isOnSale())
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                            @endif

                            @if($product->stock <= 5)
                                <span class="badge bg-warning position-absolute top-0 end-0 m-2">Low Stock</span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ $product->category->name }}</p>
                            <p class="card-text flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        @if($product->isOnSale())
                                            <span class="h5 text-danger">${{ number_format($product->sale_price, 2) }}</span>
                                            <small class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</small>
                                        @else
                                            <span class="h5">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">Stock: {{ $product->stock }}</small>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
                                    @auth
                                        @if(!auth()->user()->isAdmin() && $product->stock > 0)
                                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-sign-in-alt me-1"></i>Login to Buy
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-5x text-muted mb-3"></i>
                        <h3 class="text-muted">No products found</h3>
                        <p class="text-muted">Try adjusting your search criteria</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 