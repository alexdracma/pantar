@extends('layouts.master')

@pushonce('styles')
    <link rel="stylesheet" href="styles/auth.css">
@endpushonce

@section('content')
    @livewire('register')
@endsection
