<div class="col-12 col-sm-auto mb-2 mb-sm-0">
    <button wire:click="$toggle('showAddIngredientModal')">Add ingredient</button>

    <x-dialog-modal wire:model="showAddIngredientModal" >
        <x-slot name="title">
            {{ __('Add ingredients') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Search ingredients in the dropdown menu and select them to add them to your pantry') }}

            <div class="pt-8 pb-8 mt-4 container">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <x-select class="w-100 border-2 border-black rounded-[8px]" placeholder="Select some ingredient"
                                  :async-data="route('api.ingredientsQuery')" option-label="name" option-value="id"
                                  wire:model="selectedIngredient"/>
                    </div>
                    <div class="col-12 mt-4 mt-lg-0 col-lg-6">
                        <x-select class="w-100 border-2 border-black rounded-[8px]" placeholder="Select a unit of measurement"
                                  :options="$availableUnits" option-label="name" option-value="id"
                                  wire:model="selectedUnit" />
                    </div>
                    <div class="col-12 mt-4">
                        <x-inputs.number placeholder="Amount" wire:model="amount" class="w-100 border border-2 border-black rounded-[13px]"/>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('showAddIngredientModal')" wire:loading.attr="disabled">Cancel</button>
            <button class="ml-3" wire:click="addIngredient" wire:loading.attr="disabled">Add Ingredients</button>
        </x-slot>
    </x-dialog-modal>
</div>
