<div class="container-xxl">

    <link rel="stylesheet" href="styles/blog.css">

    @if($creatingPost)
        @livewire('create-post')
    @elseif($showRecipe)
        <link rel="stylesheet" href="styles/recipes.css">
        @livewire('recipe-detail', ['recipe' => $recipeToShow, 'memory' => $posts])
    @else
        <!-- Search Section -->
        <div class="row m-auto searchContainer py-5">
            <div class="flex-md-grow-1 mb-3 mb-md-0 me-md-3 col-12 col-sm-auto position-relative p-0">
                <img src="assets/icons/search.svg" class="searchIcon">
                <input type="search" wire:model="query" placeholder="Search by name">
            </div>
            <button class="col-12 col-sm-auto d-flex" wire:click="$toggle('creatingPost')">
                <img src="assets/icons/make_blog.svg" class="makeBlog me-2">
                <span style="color: #CDCED8 !important;">Create post</span>
            </button>
        </div>

        <!-- Recipes -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @if(count($posts) > 0)
                <div class="card p-4 text-center justify-center" wire:loading>
                    <h3>Loading...</h3>
                </div>
                @foreach($posts as $post)
                    <div class="col" wire:loading.remove>
                        <div class="card">
                            <div class="recipeData p-2 d-flex align-items-center">
                                <img src="assets/icons/portions.svg" class="me-1">
                                <span class="me-2">
                                    @if(is_array($post))
                                        {{ $post['recipe']['servings'] }}
                                    @else
                                        {{ $post->recipe->servings }}
                                    @endif
                                </span>
                                <img src="assets/icons/time.svg" class="me-1">
                                <span>
                                    @if(is_array($post))
                                        {{ $post['recipe']['readyInMinutes'] }}
                                    @else
                                        {{ $post->recipe->readyInMinutes }}
                                    @endif
                                    m
                                </span>
                            </div>
                            <img
                                @if(is_array($post))
                                    src="{{ \Illuminate\Support\Facades\Storage::url($post['recipe']['image']) }}"
                                    wire:click="showRecipe({{ $post['recipe']['id']}})"
                                @else
                                    src="{{ \Illuminate\Support\Facades\Storage::url($post->recipe->image) }}"
                                    wire:click="showRecipe({{ $post->recipe->id }})"
                                @endif
                                 class="card-img-top cursor-pointer" alt="..."
                            >
                            <div class="card-body p-2 d-flex flex-column justify-content-between">
                                @if(is_array($post))
                                    <h5 class="card-title cursor-pointer" wire:click="showRecipe({{ $post['recipe']['id']}})" >
                                        {{ $post['recipe']['title'] }}</h5>
                                @else
                                    <h5 class="card-title cursor-pointer" wire:click="showRecipe({{ $post->recipe->id }})" >
                                        {{ $post->recipe->title }}</h5>
                                @endif

                                <div class="d-flex justify-content-between mt-3 align-items-center">
                                    <div class="posterData d-flex align-items-center">
                                        <img
                                            @if(is_array($post))
                                                src="{{ $post['user']['profile_photo_url'] }}
                                            @else
                                                src="{{ $post->user->profile_photo_url }}
                                            @endif
                                            ">
                                        <span class="ms-2 h-fit">
                                            @if(is_array($post))
                                                {{ $post['user']['name'] . ' ' . $post['user']['surname'] }}
                                            @else
                                                {{ $post->user->name . ' ' . $post->user->surname }}
                                            @endif
                                        </span>
                                    </div>
                                    <img
                                        @if(is_array($post))
                                            @if(! userLikesRecipe($post['recipe']['id']))
                                                src="assets/icons/like.svg"
                                            @else
                                                src="assets/icons/like_full.svg"
                                            @endif
                                        @else
                                            @if(! userLikesRecipe($post->recipe->id))
                                                src="assets/icons/like.svg"
                                            @else
                                                src="assets/icons/like_full.svg"
                                            @endif
                                        @endif

                                        class="like"
                                        @if(is_array($post))
                                            wire:click="toggleLike({{ $post['recipe']['id'] }})"
                                        @else
                                            wire:click="toggleLike({{ $post->recipe->id }})"
                                        @endif
                                    "
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card p-4 text-center justify-center" wire:loading.remove>
                    <h3>No posts found!</h3>
                </div>
            @endif
        </div>
    @endif
</div>
