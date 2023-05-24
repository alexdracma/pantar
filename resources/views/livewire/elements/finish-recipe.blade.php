<div class="d-inline ml-2">
    <button wire:click="$toggle('showFinishRecipeModal')">Recipe done</button>
    <x-dialog-modal wire:model="showFinishRecipeModal">
        <x-slot name="title">
            {{ __('Finish recipe') }}
        </x-slot>

        <x-slot name="content">
            {{ __('The recipe you just made was designed to serve ' . $recipeToFinish->servings .
                ' people, please introduce the number of servings you made. Please note that indicating this recipe as
                finished will amount of ingredients used in it from your pantry.') }}

            <div class="mt-4">
                <x-inputs.number placeholder="Servings" wire:model="amount"/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('showFinishRecipeModal')" wire:loading.attr="disabled">Cancel</button>
            <button class="ml-3" wire:click="finishRecipe" wire:loading.attr="disabled">Finish recipe</button>
        </x-slot>
    </x-dialog-modal>
</div>
