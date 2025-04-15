@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">View Product</h2>

        <div class="mb-3">
            <label class="form-label">Product Name:</label>
            <div class="form-control bg-light">{{ $product->product_name }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Category:</label>
            <div class="form-control bg-light">
                {{ $product->category->name ?? 'N/A' }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description:</label>
            <div class="form-control bg-light" style="min-height: 100px;">{{ $product->description }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Price:</label>
                <div class="form-control bg-light">{{ number_format($product->price, 2) }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock:</label>
                <div class="form-control bg-light">{{ $product->stock }}</div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Enabled:</label>
            <div class="d-flex align-items-center">
                @if($product->enabled ?? false)
                    <span class="badge bg-success me-2">Yes</span>
                @else
                    <span class="badge bg-secondary me-2">No</span>
                @endif
            </div>
        </div>

        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary mt-3">Edit</a>
        <a href="{{ route('home') }}" class="btn btn-secondary mt-3 ms-2">Back to List</a>
    </div>
@endsection