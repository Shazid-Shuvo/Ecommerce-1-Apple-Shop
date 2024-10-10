@extends('layout.app')
@section('content')
    @include('components.MenuBar')
    @include('components.wish-list')
    @include('components.TopCategories')
    @include('components.TopBrands')
    @include('components.Footer')
    <script>
        (async () => {
            await CategoryItem();
            await WishList();
            await TopCategory();
            await TopBrands();
        })()
    </script>
@endsection
