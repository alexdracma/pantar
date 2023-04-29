@extends('layouts.app')

@section('appCSS')
    <link rel="stylesheet" href="styles/account.css">
@endsection

@section('appContent')
    <div class="container-xxl h-fit position-relative" id="userContainer">
        <img src="assets/icons/edit.svg" id="editPencil">
        <!-- Main user data row -->
        <div class="row pb-2 pt-4 d-flex align-items-center" id="userMainData">
            <div class="col-3">
                <img src="assets/images/profile picture.png" class="w-100" id="userPfp">
            </div>
            <div class="col-9 h-fit">
                <h3>Juliano Lopez McAllen</h3>
                <div class="row">
                    <div class="col-4">
                        <h6>@JuliloMc</h6>
                    </div>
                    <div class="col-8 d-flex">
                        <img src="assets/icons/birthday.svg" class="icon">
                        <h6 class="ms-3">Dec 13 1989</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- Aditional user data row -->
        <div class="row py-3">
            <div class="col-12 col-md-6">
                <ul>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/mail.svg"class="icon">
                        </div>
                        <div class="col-10">
                            <span>julilo@gmail.com</span>
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/phone.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>622 26 62 64</span>
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/password.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>********</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <ul>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/like_full.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>Favorite recipes: 5</span>
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/like_blog.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>Likes from posts: 12</span>
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/comment.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>Comments received: 3</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Logout row -->
        <div class="row px-3 pb-4">
            <div class="col text-end">
                <button class="ms-auto">Logout</button>
            </div>
        </div>
    </div>
@endsection
