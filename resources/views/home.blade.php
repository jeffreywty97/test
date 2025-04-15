@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
    </div>
    @endif
    <div class="row justify-content-center">
        @include('products.index', [['products' => $products, 'categories'=>$categories]])
    </div>
</div>
@endsection
