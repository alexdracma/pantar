<div>
    <h1>Create a new post</h1>
    <h3>Upload an image for your recipe</h3>
    <input type="file" accept=".gif,.jpg,.png,.jpeg,.svg" wire:model="photo">
    <h3>Choose a name for your new recipe</h3>
    <input type="text" wire:model="newRecipe.title">
    <h3>Add a nice description for your recipe</h3>
    <textarea wire:model="newPost.slug" cols="30" rows="10"></textarea>
    <h3>Set the amount of servings</h3>
    <x-inputs.number wire:model="newRecipe.servings"/>
    <h3>Set the minutes it takes to cook your recipe</h3>
    <x-inputs.number wire:model="newRecipe.readyInMinutes"/>
    <h3>Set a list of ingredients, and how much is needed of each</h3>
    <div class="position-relative" id="ingredientSearch">
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
    <ol class="list-decimal container-fluid">
        @foreach($ingredients as $ingredient => $data)
            <li class="row">
                <span class="col-4">{{ $ingredients[$ingredient]['name'] }}</span>
                <div class="col-4">
                    <x-inputs.number placeholder="Amount" class="w-100" wire:model="ingredients.{{ $ingredient }}.amount" />
                </div>
                <div class="col-4">
                    <x-select class="border-2 border-black rounded-[8px]" placeholder="Select a unit of measurement"
                         :options="$ingredients[$ingredient]['availableUnits']" option-label="name" option-value="id"
                              x-on:selected="Livewire.emit('test')" />
                </div>

            </li>
        @endforeach
    </ol>

    <h3>List in order the steps for your recipe, be precise!</h3>
    <button wire:click="addStep">Add a step</button>
    <ol class="list-decimal">
        @foreach($steps as $step => $data)
            <li><input type="text" wire:model="steps.{{ $step }}"></li>
        @endforeach
    </ol>

    <button wire:loading.attr="disabled" wire:click="close">Cancel</button>
    <button wire:click="seeSteps">see ingredients</button>
    <button class="ml-2" wire:click="createPost" wire:loading.attr="disabled">Create post</button>
</div>
