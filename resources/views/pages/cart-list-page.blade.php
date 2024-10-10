@extends('layout.app')
@section('content')
    @include('components.MenuBar')
    @include('components.cart-list')
    @include('components.TopCategories')
    @include('components.TopBrands')
    @include('components.Footer')
    <script>
        (async () => {
            await CategoryItem();
            await  cartList();
            await TopCategory();
            await TopBrands();
        })()
    </script>
@endsection
