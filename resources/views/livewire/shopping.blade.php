<div class="container-xxl pt-5">

    <link rel="stylesheet" href="styles/shopping.css">

    <div class="row d-flex flex-column flex-md-row">
        <div class="col-12 col-md-5 d-flex flex-column">

            <x-dialog-modal wire:model="addingIngredient">
                <x-slot name="title">
                    {{ __("Select the ingredient's amount and unit") }}
                </x-slot>

                <x-slot name="content">

                    <div class="mt-4 row">
                        <div class="col-12 col-lg-6">
                            <x-inputs.number placeholder="Amount" class="border-2 border-black rounded-[8px]"
                                             wire:model="amount"/>
                        </div>
                        <div class="col-12 col-lg-6">
                            <x-select class="border-2 border-black rounded-[8px]" placeholder="Select a unit of measurement"
                                      :options="$availableUnits" option-label="name" option-value="id" wire:model="selectedUnit" />
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <button wire:click="$toggle('addingIngredient')"
                            wire:loading.attr="disabled">Cancel</button>
                    <button class="ml-3" wire:click="selectUnitAndAmount" wire:loading.attr="disabled">Add Ingredient</button>
                </x-slot>
            </x-dialog-modal>


            <!-- Ingredient search bar -->
            <div class="col-12 position-relative" id="ingredientSearch">
                <img src="assets/icons/search.svg" class="searchIcon">
                <x-select
                    wire:model="selectedIngredient"
                    placeholder="Select an ingredient to add"
                    :async-data="route('api.ingredientsQuery')"
                    option-label="name"
                    option-value="id"
                    class="border-2 border-black rounded-[8px]"
                    id="searchBar"
                />
            </div>

            <!-- Running low box -->
            <div class="col-12 d-none d-md-block mt-3 p-3" id="runningLowBox">
                <h6>Running low</h4>
                    <div class="px-3 pb-2 row mt-3 max-h-[40vh] overflow-scroll">
                        @foreach($runningOut as $ingredient)
                            <div class="col-12">
                                <img src="{{ $ingredient->getFullImgPath() }}" class="p-2.5">
                                <span class="ms-2 pb-1">{{ $ingredient->name }}</span>
                                <img src="assets/icons/add_dark.svg" class="ms-auto d-block cursor-pointer"
                                    wire:click="openSelectIngredientAmountAndUnitPopup({{ $ingredient->id }})">
                            </div>
                        @endforeach
                    </div>
            </div>

            <button class="mt-auto text-right align-self-end mb-3" wire:click="finishShopping" wire:loading.attr="disabled">
                Finish shopping</button>
        </div>

        <div class="col-12 col-md-7 ps-lg-5">
            <!-- Pad -->
            <section class="col p-3">
                <div id="pad" class="text-center">
                    <div id="clip"></div>
                    <div class="ingredients px-3 pb-2 row pt-8 px-4 px-md-5">
                        @foreach($shoppingList as $ingredient)
                            <div class="col-12">
                                <img src="{{ $ingredient['img'] }}" class="p-2.5">
                                <span class="ms-2 pb-1 ingredient"><span class="line" wire:ignore></span>
                                    {{ $ingredient['name'] . ' (' . $ingredient['amount'] . ' ' .
                                        $ingredient['unit'] . ')' }} </span>
                                <div class="ms-auto me-2 d-flex align-items-center">

                                    <div class="check">
                                        <input type="checkbox" wire:model="checkedIngredients.{{ $ingredient['id'] }}">
                                        <span class="check">
                                            <span class="check1"></span>
                                            <span class="bg-check"><span class="check2"></span></span>
                                        </span>
                                    </div>

                                    <img src="assets/icons/trash_sm.svg" class="cursor-pointer"
                                         wire:click="removeFromShoppingList({{ $ingredient['id'] }})">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        const checks = document.querySelectorAll('input[type="checkbox"]')
        checks.forEach(check => {
            editCheck(check)
            check.addEventListener('change', function() {
                editCheck(check)
            })
        })

        function editCheck(check) {
            const line = check.parentElement.parentElement.parentElement.querySelector('span.line')

            if (check.checked) {
                line.style.width = '100%'
            } else {
                line.style.width = '0%'
            }
        }
    </script>
</div>
