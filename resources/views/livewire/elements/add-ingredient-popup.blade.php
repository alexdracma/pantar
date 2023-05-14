<div class="col-12 col-sm-auto mb-2 mb-sm-0">
    <button wire:click="$toggle('showAddIngredientModal')">Add ingredient</button>

    <x-dialog-modal wire:model="showAddIngredientModal">
        <x-slot name="title">
            {{ __('Add ingredients') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Search ingredients in the dropdown menu and select them to add them to your pantry') }}

            <div class="mt-4">
                @livewire('ingredient-search-bar')
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('showAddIngredientModal')" wire:loading.attr="disabled">Cancel</button>
            <button class="ml-3" wire:click="addIngredient" wire:loading.attr="disabled">Add Ingredients</button>
        </x-slot>
    </x-dialog-modal>
</div>