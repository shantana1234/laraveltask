<x-admin-layout>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Category
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        @if($category->image)
                                            @php
                                                $imageSrc = filter_var($category->image, FILTER_VALIDATE_URL) 
                                                    ? $category->image 
                                                    : asset('storage/' . $category->image);
                                            @endphp
                                            <img src="{{ $imageSrc }}" 
                                                 alt="{{ $category->name }}" class="rounded" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td>{{ $category->products_count ?? 0 }}</td>
                                    <td>
                                        <span class="badge bg-{{ $category->status ? 'success' : 'danger' }}">
                                            {{ $category->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $categories->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No categories found</h3>
                    <p class="text-muted">Create your first category to get started</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Category
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout> 