@extends('layouts.master')
@section('content')
    <div class="d-flex">
        <livewire:sidebar />

        <main class="flex-grow-1">

            @livewire('shopping')

        </main>
    </div>
@endsection
