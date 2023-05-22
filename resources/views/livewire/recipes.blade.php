<div>

    <link rel="stylesheet" href="styles/recipes.css">

    <div class="container-xxl">
        <!-- Search Section -->
        <div class="row m-auto searchContainer py-5">
            @livewire('search-from-pantry')
            <div class="flex-md-grow-1 ms-md-3 col-12 col-sm-auto position-relative p-0">
                <img src="assets/icons/search.svg" class="searchIcon">
                <input type="search" wire:model.debounce.500ms="query" placeholder="Search by name">
            </div>
        </div>

        <!-- Recipes -->
        <div class="row m-auto">
            @if(count($shownRecipes) > 0)
                @foreach($shownRecipes as $recipe)
                    <div class="card mb-3 ps-0">
                        <div class="row h-100">
                            <div class="col-lg-4 pe-0">
                                <img
                                    @if(is_array($recipe))
                                        src="{{ 'https://spoonacular.com/recipeImages/' . $recipe['image'] }}"
                                    @else
                                        src="{{ 'https://spoonacular.com/recipeImages/' . $recipe->image }}"
                                    @endif
                                    class="recipeImg" alt="...">
                            </div>
                            <div class="col-lg-8 p-0">
                                <div class="card-body h-100 d-flex flex-column justify-content-end">
                                    <h4 class="card-title mb-auto">
                                        @if(is_array($recipe))
                                            {{ $recipe['title'] }}
                                        @else
                                            {{ $recipe->title }}
                                        @endif
                                    </h4>
                                    <div class="card-text mt-2 d-flex">
                                        <img src="assets/icons/portions.svg" class="recipeIcon">
                                        <span class="ms-2"><b>
                                                @if(is_array($recipe))
                                                    {{ $recipe['servings'] }}
                                                @else
                                                    {{ $recipe->servings }}
                                                @endif
                                            </b> Servings</span>
                                    </div>
                                    <div class="card-text d-flex justify-content-between align-items-end">
                                        <span class="d-flex">
                                            <img src="assets/icons/time.svg" class="recipeIcon">
                                            <span class="ms-2"><b>
                                                    @if(is_array($recipe))
                                                        {{ $recipe['readyInMinutes'] }}
                                                    @else
                                                        {{ $recipe->readyInMinutes }}
                                                    @endif
                                                </b> Minutes</span>
                                        </span>
                                        <img
                                            @if(is_array($recipe))
                                                @if(! userLikesRecipe($recipe['id']))
                                                    src="assets/icons/like.svg"
                                                @else
                                                src="assets/icons/like_full.svg"
                                               @endif
                                            @else
                                                @if(! userLikesRecipe($recipe->id))
                                                    src="assets/icons/like.svg"
                                                @else
                                                    src="assets/icons/like_full.svg"
                                                @endif
                                            @endif

                                            class="recipeIcon"
                                            @if(is_array($recipe))
                                                wire:click="toggleLike({{ $recipe['id'] }})"
                                            @else
                                                wire:click="toggleLike({{ $recipe->id }})"
                                            @endif
                                            "
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card p-4 text-center justify-center" wire:loading.remove>
                    <h3>Nothing here yet! Type in the search bar or click the 'Search from
                        your pantry' to start cooking</h3>
                </div>
                <div class="card p-4 text-center justify-center" wire:loading>
                    <h3>Loading...</h3>
                </div>

            @endif
        </div>
    </div>
</div>
