@extends('layouts.master')
@section('content')
    <div class="d-flex">
        <livewire:sidebar />

        <main class="flex-grow-1">

            <link rel="stylesheet" href="styles/recipes.css">

            <div class="container-xxl">
                @livewire('recipe-detail', ['recipe' => 365, 'memory' => []])
            </div>

        </main>
    </div>
@endsection
