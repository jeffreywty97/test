@extends('layouts.app')

@section('content')
    @php
        $action = isset($product->id) ? route('products.update', $product->id) : route('products.store');
        $heading = isset($product->id) ? "Edit Product" : "Create a New Product";
        $button = isset($product->id) ? "Edit" : "Create";
    @endphp

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ $error }}</strong>
        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> --}}
    </div>
    @endforeach
    @endif
    <form action="{{ $action }}" method="POST" class="container mt-5">
        @csrf
        @if(isset($product->id))
            @method('PUT')
        @endif
        <h2 class="mb-4">{{ $heading }}</h2>

        <div class="mb-3">
            <label for="name" class="form-label">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->product_name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <select class="form-select" name="category" id="category" required>
                <option value="" disabled selected>--Select a Category--</option>
                @isset($categories)
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == old('category', $product->category_id ?? '') ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach 
                @endisset
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" rows="5" id="description" name="description" required>{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" id="price" name="price" min="0.00" max="10000.00" step="0.01" value="{{ old('price', $product->price ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
            </div>
        </div>

        <div class="mb-3 form-check form-switch">
            <input type="hidden" name="enabled" value="0">
            <label class="form-check-label" for="enabled">Enabled</label>
            <input type="checkbox" class="form-check-input" id="enabled" name="enabled" value="1" {{ old('enabled', $product->enabled ?? false) ? 'checked' : '' }}>                        
        </div>

        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}"> 

        <button type="submit" class="btn btn-primary mt-3">{{ $button }}</button>
        <a href="{{ route('home') }}" class="btn btn-secondary mt-3 ms-2">Back to List</a>
    </form>
@endsection