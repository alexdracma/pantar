<div class="container-xxl">

    <link rel="stylesheet" href="styles/blog.css">

    @if($creatingPost)
        @livewire('create-post')
    @else
        <!-- Search Section -->
        <div class="row m-auto searchContainer py-5">
            <div class="flex-md-grow-1 mb-3 mb-md-0 me-md-3 col-12 col-sm-auto position-relative p-0">
                <img src="assets/icons/search.svg" class="searchIcon">
                <input type="search" name="" placeholder="Search by name">
            </div>
            <button class="col-12 col-sm-auto d-flex" wire:click="$toggle('creatingPost')">
                <img src="assets/icons/make_blog.svg" class="makeBlog me-2">
                <span style="color: #CDCED8 !important;">Create post</span>
            </button>
        </div>

        <!-- Recipes -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($posts as $post)
                <div class="col">
                    <div class="card">
                        <div class="recipeData p-2 d-flex align-items-center">
                            <img src="assets/icons/portions.svg" class="me-1">
                            <span class="me-2">{{ $post->recipe->servings }}</span>
                            <img src="assets/icons/time.svg" class="me-1">
                            <span>{{ $post->recipe->readyInMinutes }}m</span>
                        </div>
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($post->recipe->image) }}" class="card-img-top" alt="...">
                        <div class="card-body p-2 d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $post->recipe->title }}</h5>
                            <div class="d-flex justify-content-between mt-3 align-items-center">
                                <div class="posterData d-flex align-items-center">
                                    <img src="assets/images/profile picture.png">
                                    <span class="ms-2 h-fit">{{ $post->user->name . ' ' . $post->user->surname }}</span>
                                </div>
                                <img src="assets/icons/like.svg" class="like">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
