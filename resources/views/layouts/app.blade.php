@extends('layouts.master')

@section('css')
    {{--  Sidebar CSS  --}}
    <link rel="stylesheet" href="styles/sidebar.css">
    {{--  Extra styles  --}}
    @yield('appCSS')
@endsection

@section('scripts')
    {{--  Sidebar script  --}}
    <script defer src="scripts/sidebar.js"></script>
    {{--  Extra scripts  --}}
    @yield('appScripts')
@endsection

@section('bodyClass')
    d-flex
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection

@section('content')
    <main class="flex-grow-1 d-flex justify-content-center pt-5">
        @yield('appContent')
    </main>
@endsection
