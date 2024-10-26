@extends('layout.side-nav')
@section('content')
    @include('components.admin.category.category-list')
    @include('components.admin.category.create-category')
    @include('components.admin.category.update-category')
    @include('components.admin.category.delete-category')
@endsection
