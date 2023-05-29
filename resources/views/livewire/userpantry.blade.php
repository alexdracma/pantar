<div>
    <link rel="stylesheet" href="styles/pantry.css">

    <!-- Search bar section -->
    <div id="search" class="z-50 py-4 pt-md-7 pb-md-5 mx-3 mx-md-0">
        <div class="row m-auto">
            @livewire('add-ingredient-popup')
            <div class="flex-md-grow-1 ms-md-3 col-12 col-sm-auto position-relative p-0">
                <img src="assets/icons/search.svg" class="searchIcon">
                <input type="search" wire:model="query" placeholder="Search ingredients in your pantry">
            </div>
        </div>
    </div>
    <div class="container-xxl">

    <!-- Ingredient Modal -->
        @if($modalIngredientData !== null)
            <x-dialog-modal wire:model="showIngredientModal" class="z-50">
                <x-slot name="title"></x-slot>

                <x-slot name="content">

                    <div class="mt-4 container">
                        <div class="row">
                            <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                                <div class="bordered border-2 border-black bg-white h-52 p-2 rounded-[8px] d-flex
                                align-items-center justify-content-center w-100">
                                    <img src="{{ $modalIngredientData['imgPath'] }}" class="img-fluid">
                                </div>
                                <h5 class="mt-2">{{ $modalIngredientData['name'] }}</h5>
                            </div>
                            <div class="col-8">
                                <div class="col-12 p-3">
                                    <h4>You have <b>{{ $modalIngredientData['amount'] }}</b> {{ $modalIngredientData['unit'] }}</h4>
                                </div>
                                <div class="col-12 text-end p-2">
                                    <button wire:click="$toggle('showIngredientModal')" wire:loading.attr="disabled">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer"></x-slot>
            </x-dialog-modal>
        @endif

        <!-- Ingredients grid -->
        <div id="grid"
             class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 position-relative g-0 p-0 mb-5 mt-4">

            @foreach($shownIngredients as $ingredient)
                @php
                    if (is_array($ingredient)) {
                        $ingredient = \App\Models\Ingredient::find($ingredient['id']);
                    }
                @endphp
                <div class="col">
                    <div class="z-30 d-flex flex-column justify-content-center align-items-center" wire:click="showIngredient({{$ingredient->id}})">
                        <div class="ingredientImage"><img src="{{ $ingredient->getFullImgPath() }}" class="ingredient"></div>
                        <div class="ingredientName mt-2">{{ $ingredient->name }}</div>
                    </div>
                </div>
            @endforeach

           @if(count($shownIngredients) < 60) {{--  Filler blanks in case there're too few to display--}}
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
