@extends('layout.app')
@section('content')
    @include('components.MenuBar')
    @include('components.product-details')
    @include('components.TopCategories')
    @include('components.TopBrands')
    @include('components.Footer')
    <script>
        (async () => {
            await CategoryItem();
            await  productDetails();
            await TopCategory();
            await TopBrands();
        })()
    </script>
@endsection

