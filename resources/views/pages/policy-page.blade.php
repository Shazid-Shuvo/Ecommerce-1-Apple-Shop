@extends('layout.app')
@section('content')
    @include('components.MenuBar')
    @include('components.policy')
    @include('components.TopBrands')
    @include('components.Footer')
    <script>
        (async () => {
            await CategoryItem();
            await Policy()
            await TopBrands();
        })()
    </script>
@endsection
