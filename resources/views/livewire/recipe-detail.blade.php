<div>
    <div class="card mb-3 ps-0 mt-12">
        <div class="row h-100">
            <div class="col-lg-5 pe-0">
                <img src="{{ $shownRecipe->getFullImgPath() }}" class="recipeImg" alt="...">
            </div>
            <div class="col-lg-7 p-0">
                <div class="card-body h-100 d-flex flex-column justify-content-end">
                    <h3 class="card-title mb-auto cursor-pointer pe-2">{{ $shownRecipe->title }} </h3>
                    <div class="card-text mt-2 d-flex">
                        <img src="assets/icons/portions.svg" class="recipeIcon">
                        <span class="ms-2"><b>{{ $shownRecipe->servings }}</b> Servings</span>
                    </div>
                    <div class="card-text d-flex justify-content-between align-items-end">
                        <span class="d-flex">
                            <img src="assets/icons/time.svg" class="recipeIcon">
                            <span class="ms-2"><b>{{ $shownRecipe->readyInMinutes }}</b> Minutes</span>
                        </span>
                        <img
                            @if(! $userLikes)
                                src="assets/icons/like.svg"
                            @else
                                src="assets/icons/like_full.svg"
                            @endif

                            class="recipeIcon me-2" wire:click="toggleLike"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3 p-4 mt-10">
        <div class="row h-100">
            <div class="col-12 col-lg-6">
                <h3 class="mt-1 mb-4">Ingredients</h3>
                <ul class="ps-2 pe-1">
                    @foreach($shownRecipe->ingredients as $ingredient)
                        <li class="my-1.5 w-100 d-flex justify-between">
                            <span>
                                {{ $ingredient->pivot->recipeIngredientName }}
                            </span>
                            <span class="ms-1">
                                {{ $ingredient->pivot->amount }} {{ $this->getUnitName($ingredient->pivot->unit) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-12 col-lg-6">
                <h3 class="mt-1 mb-4">Steps</h3>
                <ol class="list-decimal">
                    @foreach($shownRecipe->steps as $step)
                        <li class="my-1.5">{{ $step->data }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    <div class="d-flex justify-end mt-10">
        <a href="{{ $shownRecipe->source }}" class="text-decoration-none text-[#7DCCDAFF] align-self-end"
            target="_blank">Original recipe</a>
        <button class="ml-5" wire:click="close" wire:loading.attr="disabled">Back</button>
        @livewire('finish-recipe', ['recipeToFinish' => $shownRecipe])
    </div>
</div>
