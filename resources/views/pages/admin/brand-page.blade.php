@extends('layout.side-nav')
@section('content')
    @include('components.admin.brand.brand-list')
    @include('components.admin.brand.create-brand')
    @include('components.admin.brand.delete-brand')
    @include('components.admin.brand.update-brand')
@endsection
