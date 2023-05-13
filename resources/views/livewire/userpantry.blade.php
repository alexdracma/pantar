<div>
    <link rel="stylesheet" href="styles/pantry.css">

    <!-- Search bar section -->
    <div id="search" class="py-4 pt-md-7 pb-md-5 mx-3 mx-md-0">
        <div class="row m-auto">
            @livewire('add-ingredient-popup')
            <div class="flex-md-grow-1 ms-md-3 col-12 col-sm-auto position-relative p-0">
                <img src="assets/icons/search.svg" class="searchIcon">
                <input type="search" wire:model="query" placeholder="Search ingredients in your pantry">
            </div>


    </div>

    <div class="container-xxl">

        <!-- Ingredients grid -->
        <div id="grid"
             class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 position-relative g-0 p-0 mb-5 mt-4">

            @foreach($shownIngredients as $ingredient)
                <div class="col">
                    <div class="ingredientImage"><img src="assets/images/ingredients/broccoli.png" class="ingredient"></div>
                    <div class="ingredientName mt-2">{{ $ingredient->name }}</div>
                </div>
            @endforeach

            @if(count($shownIngredients) < 60) {{-- Filler blanks in case there're too few to display --}}
                @for($i = count($shownIngredients); $i < 60; $i++)
                    <div class="col" style="min-height: 120px">
                        <div class="ingredientImage"></div>
                        <div class="ingredientName mt-2"></div>
                    </div>
                @endfor
            @endif

            <div class="position-absolute h-100 d-flex justify-content-between" id="blueColumns">
                <div class="blueLine"></div>
                <div class="blueLine"></div>
                <div class="blueLine d-none d-md-block"></div>
                <div class="blueLine d-none d-lg-block"></div>
                <div class="blueLine d-none d-xl-block"></div>
                <div class="blueLine d-none d-xxl-block"></div>
                <div class="blueLine"></div>
            </div>
        </div>
    </div>

</div>
