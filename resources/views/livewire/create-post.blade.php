<div>

    <h1 class="pt-7">Create a new post</h1>

    <div class="card mb-3 ps-0 mt-12">
        <div class="row h-100 py-2 px-3">
            <div class="col-12 col-lg-6 p-3">
                <h4 class="mb-3">Upload an image</h4>
                <input type="file" accept=".gif,.jpg,.png,.jpeg,.svg" wire:model="photo" class="block w-full text-sm
                    border-2 border-black rounded-[8px] text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:border-0
                    file:p-0 file:text-sm file:font-semibold file:bg-[#31525B] file:text-[#F6F4EA] cursor-pointer "/>
            </div>
            <div class="col-12 col-lg-6 p-3">
                <h4 class="mb-3">Choose a name</h4>
                <input type="text" wire:model="newRecipe.title" class="block w-full border-2 border-black rounded-[8px]">
            </div>

        </div>
    </div>

    <div class="card mb-3 ps-0">
        <div class="row h-100 py-3 px-4">
            <h4>Add a nice description for your recipe</h4>
            <textarea wire:model="newPost.slug" rows="4" class="w-full border-2 border-black rounded-[8px]"></textarea>
        </div>
    </div>

    <div class="card mb-3 ps-0">
        <div class="row h-100 py-2 px-3">
            <div class="col-12 col-lg-6 p-3">
                <h4 class="mb-3">Set the amount of servings</h4>
                <x-inputs.number wire:model="newRecipe.servings" placeholder="Servings" class="w-full border-2
                    border-black rounded-[12px]"/>
            </div>
            <div class="col-12 col-lg-6 p-3">
                <h4 class="mb-3">Set the minutes to cook it </h4>
                <x-inputs.number wire:model="newRecipe.readyInMinutes" placeholder="Minutes" class="w-full border-2
                    border-black rounded-[12px]"/>
            </div>
        </div>
    </div>

    <div class="card mb-3 ps-0">
        <div class="row h-100 py-4 px-4">
            <h4 class="mb-3">Set a list of ingredients, and how much is needed of each</h4>
            <div class="px-3">
                <x-select
                    wire:model="selectedIngredient" placeholder="Select an ingredient to add"
                    :async-data="route('api.ingredientsQuery')" option-label="name" option-value="id"
                    class="border-2 border-black rounded-[8px] p-0" id="searchBar" />
            </div>
        </div>
    </div>

    <ol class="list-decimal container-fluid">
        @foreach($ingredients as $ingredient => $data)
            <li class="row border-2 border-black rounded-[8px] p-2 bg-white d-flex align-items-center mb-1">
                <span class="col-2">{{ $ingredients[$ingredient]['name'] }}</span>
                <div class="col-5">
                    <x-inputs.number placeholder="Amount" class="w-full border-2 border-black rounded-[12px]"
                        wire:model="ingredients.{{ $ingredient }}.amount" />
                </div>
                <div class="col-5">
                    <select wire:change="setUnit({{ $ingredient }}, $event.target.value)" class="border-2 border-black
                        rounded-[8px] w-100">
                        <option value="null">Select a unit</option>
                        @foreach($ingredients[$ingredient]['availableUnits'] as $unit)
                            @if(is_array($unit))
                                <option value="{{$unit['id']}}">{{$unit['name']}}</option>
                            @else
                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                            @endif

                        @endforeach
                    </select>
                </div>
            </li>
        @endforeach
    </ol>

    <div class="card mb-3 ps-0">
        <div class="row h-100 py-2 px-3">
            <div class="col-12 col-lg-6 p-3 d-flex flex-column">
                <h4 class="mb-3 text-center">List in order the steps for your recipe, be precise!</h4>
                <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                    <button wire:click="addStep">Add a step</button>
                </div>
            </div>
            <div class="col-12 col-lg-6 p-3">
                <ol class="list-decimal container-fluid">
                    @foreach($steps as $step => $data)
                        <li class="mb-1"><input type="text" wire:model="steps.{{ $step }}" class="border-2 border-black
                        rounded-[8px] w-100"></li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end my-5">
        <button wire:loading.attr="disabled" wire:click="close">Cancel</button>
        <button class="ml-2" wire:click="createPost" wire:loading.attr="disabled">Create post</button>
    </div>
</div>
