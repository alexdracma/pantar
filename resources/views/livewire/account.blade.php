<div class="d-flex justify-content-center pt-5 flex-column">

    <link rel="stylesheet" href="styles/account.css">

    <div class="container-xxl h-fit position-relative userContainer">
        @if(!$editing)
            <img src="assets/icons/edit.svg" id="editPencil" wire:click="editProfile">
        @endif

        <!-- Main user data row -->
        <div class="row pb-2 pt-4 d-flex align-items-center" id="userMainData">
            <div class="col-3">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                     class="rounded-full h-36 w-36 object-cover" id="userPfp">
            </div>
            <div class="col-9 h-fit">
                @if($editing)
                    <div class="row p-0 m-0">
                        <div class="col-6 p-1">
                            <input type="text" wire:model="user.name" class="w-100">
                        </div>
                        <div class="col-6 p-1">
                            <input type="text" wire:model="user.surname" class="w-100">
                        </div>
                    </div>
                @else
                    <h3> {{ $this->fullName() }}</h3>
                @endif

                <div class="row">
                    <div class="col">
                        <h6>{{ '@' . $user->username }}</h6>

                    </div>
                </div>
            </div>
        </div>
        <!-- Aditional user data row -->
        <div class="row py-3">
            <div class="col-12 col-md-6">
                <ul>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/mail.svg"class="icon">
                        </div>
                        <div class="col-10">
                            @if($editing)
                                <span><input type="email" wire:model="user.email" class="w-100"></span>
                            @else
                                <span>{{ $user->email }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/phone.svg" class="icon">
                        </div>
                        <div class="col-10">
                            @if($editing)
                                <span><input type="tel" wire:model="user.phone" class="w-100">
                                </span>
                            @else
                                @if($user->phone === null)
                                    <span>Not set</span>
                                @else
                                    <span>{{ $user->phone }}</span>
                                @endif
                            @endif
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/birthday.svg" class="icon">
                        </div>
                        <div class="col-10">
                            @if($editing)
                                <span><input type="date" wire:model="user.birthday" class="w-100"></span>
                            @else
                                <span>{{ $this->getBirthdayFormated() }}</span>
                            @endif

                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <ul>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/like_full.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>Favorite recipes: {{ $user->favorites->count() }}</span>
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/like_blog.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>Likes from posts: {{ $user->likesFromPosts->count() }}</span>
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-2 text-center">
                            <img src="assets/icons/comment.svg" class="icon">
                        </div>
                        <div class="col-10">
                            <span>Comments received: {{ $user->commentsFromPosts->count() }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Logout row -->
        <div class="row px-3 pb-4">
            <div class="col text-end d-flex justify-content-end">
{{--                Differentiate between updating profile or not--}}
                @if ($editing)
                    @livewire('change-password')
                    <button class="ms-2" wire:click="editProfile">Cancel</button>
                    <button class="ms-2" wire:click="sync">Save</button>
                @else
                    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                        @livewire('profile.delete-user-form')
                    @endif

                    <button class="ms-2" wire:click="logout">Logout</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Browser Sessions -->
    <div class="userContainer container-xxl h-fit position-relative mt-3 p-3">
        <h5>Browser Sessions</h5>
        @livewire('profile.logout-other-browser-sessions-form')
    </div>

{{--    <div class="userContainer container-xxl h-fit position-relative mt-3 p-3">--}}
{{--        <x-select--}}

{{--            class="w-100 border-2 border-black rounded-[8px]"--}}

{{--            placeholder="Select some recipe"--}}

{{--            :async-data="route('api.recipesQuery')"--}}

{{--            option-label="title"--}}

{{--            option-value="id"--}}

{{--        />--}}
{{--    </div>--}}

</div>
