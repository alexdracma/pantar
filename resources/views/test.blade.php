@extends('layouts.master')
@section('content')
    <div class="d-flex">
        <livewire:sidebar />

        <main class="flex-grow-1">

            <div class="container-xxl">

                <link rel="stylesheet" href="styles/recipes.css">
                @livewire('recipe-detail', ['recipe' => 38, 'memory' => ''])

            </div>

        </main>
    </div>
@endsection
