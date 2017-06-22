@extends('layout.master')

@section('left-sidebar')
    @include('partials.left_sidebar_menu')
@stop

@section('main-content')

@stop

@section('top')
    @include('partials.top_sidebar_menu')
@stop

@section('bottom-sidebar')
    @include('partials.bottom_sidebar_menu')
@stop

@section('script')
    <script>
        $(document).ready(function() {

            $('#left_sidebar')
                    .sidebar('attach events', '#sidebar_menu')
        })

    </script>
@stop