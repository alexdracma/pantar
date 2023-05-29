<div>
    <div class="card mb-3 ps-0 mt-12">
        <div class="row h-100">
            <div class="col-lg-5 pe-0">
                @if($isPost)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->recipe->image) }}" class="recipeImg" alt="...">
                @else
                    <img src="{{ $shownRecipe->getFullImgPath() }}" class="recipeImg" alt="...">
                @endif
            </div>
            <div class="col-lg-7 p-0">
                <div class="card-body h-100 d-flex flex-column justify-content-end">
                    <h3 class="card-title mb-auto pe-2">{{ $shownRecipe->title }} </h3>
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

    @if($isPost)
        <div class="card mb-3 p-4">
            <div class="h-100 d-flex flex-column justify-content-between">
                <h4>Description</h4>
                <p>{{ $post->slug }}</p>
                <div class="mt-3">Recipe by: <br> <img src="{{ $post->user->profile_photo_url }}"
                    class="rounded-full border-2 border-black w-9 h-9 d-inline-block"> {{ $post->user->name }}
                    {{ $post->user->surname }}</div>
            </div>
        </div>
    @endif

    <div class="card mb-3 p-4 mt-3">
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
                                {{ $ingredient->pivot->amount }} {{ getUnitNameById($ingredient->pivot->unit) }}
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

    @if($isPost)
        <div class="card mb-3 p-4 mt-3 !min-h-fit">
            <div class="row">
                <div class="d-flex justify-content-between">
                    <h4>Give your feedback</h4>
                    <div class="d-flex flex-row-reverse">
                        <img src="assets/icons/comment.svg" class="w-10 cursor-pointer ms-3"
                             wire:click="$toggle('commenting')">
                        <img
                            @if(userLikesPost($post->id))
                                src="assets/icons/like_blog_colored.svg"
                            @else
                                src="assets/icons/like_blog.svg"
                            @endif
                            class="w-9 cursor-pointer" wire:click="togglePostLike">
                    </div>
                </div>

            </div>
        </div>

        @if($commenting)
            <div class="card mb-3 p-4 mt-3 !min-h-fit">
                <h4 class="mb-3">Add your comment</h4>
                <textarea wire:model="comment" rows="2" class="w-full border-2 border-black rounded-[8px]"></textarea>
                <button class="ms-auto mt-4" wire:click="addPostComment">Add comment</button>
            </div>
        @endif

        <div class="card mb-3 p-4 mt-3 !min-h-fit">
            <div class="row">
                <h4 class="mb-3">Comments</h4>
                <ul class="list-none container-fluid max-h-44 overflow-auto comments">
                    @foreach($post->comments as $comment)
                        <li class="mb-1"><img src="{{ $post->user->profile_photo_url }}" class="rounded-full border-2
                        border-black w-8 h-8 d-inline-block"> {{ $comment->username }}: {{ $comment->pivot->content }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="d-flex justify-end mt-10 mb-5">
        <a href="{{ $shownRecipe->source }}" class="text-decoration-none text-[#7DCCDAFF] align-self-end"
            target="_blank">Original recipe</a>
        <button class="ml-5" wire:click="close" wire:loading.attr="disabled">Back</button>
        @livewire('finish-recipe', ['recipeToFinish' => $shownRecipe])
    </div>
</div>
