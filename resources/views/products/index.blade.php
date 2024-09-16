@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Product List</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-4">Create New Product</a>


        <!-- Search Form -->
        <form method="GET" action="{{ route('products.index') }}" class="mb-4">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <input type="text" name="search" value="{{ old('search', $search) }}" class="form-control" placeholder="Search by name">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </div>
        </form>

        <!-- Product Table -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'code', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Code
                            @if ($sortField === 'code')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'category', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Category
                            @if ($sortField === 'category')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'name', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Name
                            @if ($sortField === 'name')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'description', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Description
                            @if ($sortField === 'description')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'selling_price', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Selling Price
                            @if ($sortField === 'selling_price')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'special_price', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Special Price
                            @if ($sortField === 'special_price')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'status', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Status
                            @if ($sortField === 'status')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'is_delivery_available', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Is Delivery Available
                            @if ($sortField === 'is_delivery_available')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        Image
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'created_at', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Created At
                            @if ($sortField === 'created_at')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'updated_at', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                            Updated At
                            @if ($sortField === 'updated_at')
                                @if ($sortOrder === 'asc') <i class="fas fa-chevron-up"></i> @else <i class="fas fa-chevron-down"></i> @endif
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->selling_price }}</td>
                        <td>{{ $product->special_price }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->is_delivery_available }}</td>
                        <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 100px;"></td>
                        <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $product->updated_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm">Edit</a>

                            <!-- Delete Form -->
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $products->appends(['sort' => $sortField, 'order' => $sortOrder, 'search' => $search])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

@endsection