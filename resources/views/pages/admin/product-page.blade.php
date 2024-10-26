@extends('layout.side-nav')
@section('content')
    @include('components.admin.product.product-list')
    @include('components.admin.product.create-product')
    @include('components.admin.product.update-product')
    @include('components.admin.product.delete-product')
@endsection
