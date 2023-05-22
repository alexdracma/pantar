<div class="container-xxl">

    <link rel="stylesheet" href="styles/favorites.css">

    <!-- Search Section -->
    <div class="row m-auto searchContainer py-5 d-flex justify-content-center">
        <div class="col-12 position-relative p-0">
            <img src="assets/icons/search.svg" class="searchIcon">
            <input type="search" wire:model="query" placeholder="Search your favorite recipes">
        </div>
    </div>

    <!-- Recipes -->
    <div class="row m-auto">
        @foreach($shownFavorites as $favorite)
            <div class="card mb-3 ps-0">
                <div class="row h-100">
                    <div class="col-lg-4 pe-0">
                        <img src="{{ 'https://spoonacular.com/recipeImages/' . $favorite->image }}"
                             class="recipeImg" alt="...">
                    </div>
                    <div class="col-lg-8 p-0">
                        <div class="card-body h-100 d-flex flex-column justify-content-end">
                            <h4 class="card-title mb-auto">{{ $favorite->title }}</h4>
                            <div class="card-text mt-2 d-flex">
                                <img src="assets/icons/portions.svg" class="recipeIcon">
                                <span class="ms-2 align-self-end"><b>{{ $favorite->servings }}</b> Serving</span>
                            </div>
                            <div class="card-text d-flex justify-content-between align-items-end">
                            <span class="d-flex">
                                <img src="assets/icons/time.svg" class="recipeIcon">
                                <span class="ms-2 align-self-end"><b>{{ $favorite->readyInMinutes }}</b> Minutes</span>
                            </span>
                                <img src="assets/icons/like_full.svg" class="recipeIcon cursor-pointer"
                                    wire:click="removeFavorite({{ $favorite->id }})">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
    </div>
</div>
{{--$favorite->id--}}
