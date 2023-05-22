<div class="col-12 col-sm-auto mb-2 mb-md-0">
    <button wire:click="$toggle('showSelectIngredientModal')">Search from your pantry</button>

    <x-dialog-modal wire:model="showSelectIngredientModal">
        <x-slot name="title">
            {{ __('Select ingredients to search') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Search from your ingredients in the dropdown to find recipes') }}

            <div class="mt-4">
                <x-select class="w-100 border-2 border-black rounded-[8px]" placeholder="Select some ingredients"
                    :async-data="route('api.userIngredients')" option-label="name" option-value="name"
                    multiselect wire:model="selectedIngredients"/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('showSelectIngredientModal')" wire:loading.attr="disabled">Cancel</button>
            <button class="ml-3" wire:click="search" wire:loading.attr="disabled">Search</button>
        </x-slot>
    </x-dialog-modal>
</div>
