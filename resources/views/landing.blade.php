@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="styles/landing.css">
@endsection

@section('content')

    <!-- landing header -->
    <header class="container-xxl d-flex flex-column">
        <nav class="row pt-5">
            <div class="col-6">
                <!-- Logo -->
                <img src="assets/images/title.svg" id="mainLogo">
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <a href="" class="fs-5 fw-semibold">Login</a>
                <button class="ms-3">Get Started Free</button>
            </div>
        </nav>
        <div class="flex-grow-1 row d-flex align-items-center" id="hero">
            <div class="col-6 p-5">
                <h1>Today's breakfast, lunch and dinner.</h1>
                <h1>Easy and fast</h1>
            </div>
            <div class="col-6">
                <img src="assets/images/landing-cart.png">
            </div>
        </div>
    </header>

    <!-- Recipes section -->
    <section class="container-xxl p-5" id="recipes">
        <div class="row w-90">
            <div class="col-7 py-4">
                <img src="assets/images/landing-recipes.png">
            </div>
            <div class="col-5 p-5">
                <h2>Thousands of recipes based on what you have right at home</h2>
            </div>
        </div>
    </section>

    <!-- Pantry section -->
    <section class="container-xxl p-5" id="pantry">
        <div class="row w-90">
            <div class="col-5 p-5">
                <h2>Store the items on your pantry and get notifications when you're running out to add them to your
                    shopping list</h2>
            </div>
            <div class="col-7 py-4">
                <img src="assets/images/landing-pantry.png">
            </div>
        </div>
    </section>

    <!-- Blog section -->
    <section class="container-xxl p-5" id="blog">
        <div class="row w-90">
            <div class="col-7 py-4">
                <img src="assets/images/landing-blog.png">
            </div>
            <div class="col-5 p-5">
                <h2>Create new recipes and share them in our blog</h2>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="container-xxl">
        <div class="w-50 m-auto text-center m-5 py-5 mb-4">
            <h2>Ready to start cooking? Start with Pantar, save money and the planet</h2>
            <button class="mt-4">Get Started Free</button>
        </div>

        <!-- Footer navbar -->
        <nav>
            <div class="row">
                <div class="col-3">
                    <!-- Logo -->
                    <img src="assets/images/title.svg" class="logo">
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="" class="nav-link">About</a></li>
                        <li class="nav-item">
                            <a href="" class="nav-link">Features</a></li>
                        <li class="nav-item">
                            <a href="" class="nav-link">Works</a></li>
                        <li class="nav-item">
                            <a href="" class="nav-link">Support</a></li>
                    </ul>
                </div>
                <div class="col-3 d-flex justify-content-end align-items-center">
                    <!-- Social icons -->

                    <ul class="nav" id="socials">
                        <li class="nav-item">
                            <a href="https://twitter.com" class="nav-link">
                                <img src="assets/icons/twitter.svg"></a></li>
                        <li class="nav-item">
                            <a href="https://facebook.com" class="nav-link">
                                <img src="assets/icons/facebook.svg"></a></li>
                        <li class="nav-item">
                            <a href="https://instagram.com" class="nav-link">
                                <img src="assets/icons/instagram.svg"></a></li>
                        <li class="nav-item">
                            <a href="https://github.com/alexdracma/pantar" class="nav-link">
                                <img src="assets/icons/github.svg"></a></li>
                    </ul>
                </div>
            </div>

            <!-- Copy bar -->
            <hr>
            <div class="row py-2" id="copyBar">
                <div class="col-6">
                    <p>© Copyright 2023, All Rights Reserved</p>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <p class="me-4">Privacy Policy</p>
                    <p>Terms & Conditions</p>
                </div>
            </div>
            </div>
    </footer>
@endsection
