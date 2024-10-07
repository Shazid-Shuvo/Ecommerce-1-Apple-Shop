@extends('layout.app')
@section('content')
    @include('components.MenuBar')
    @include('components.product-by-brand')
    @include('components.TopCategories')
    @include('components.ExclusiveProducts')
    @include('components.TopBrands')
    @include('components.Footer')
    <script>
        (async () => {
            await CategoryItem();
            await ProductByBrand();
            await ProductByCategory();
            await TopCategory();
            await Popular();
            await New();
            await Top();
            await Special();
            await Trending();
            await TopBrands();
        })()
    </script>
@endsection
