<div class="container d-flex flex-column align-items-center position-absolute top-50 start-50 translate-middle">
    <div class="logo mb-3">
        <img src="assets/images/title.svg" class="img-fluid">
    </div>
{{--    method="POST" action="{{ route('register') }}" --}}
    <form wire:submit.prevent="register(Object.fromEntries(new FormData($event.target)))" class="p-3">
        @csrf

        <div class="col-12 mt-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control
                    @error('name')border-danger @enderror" wire:model.lazy="name">
            @error('name')
            <div id="nameHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 mt-3">
            <label for="surname" class="form-label">Surname/s or Last name</label>
            <input type="text" name="surname" id="surname" class="form-control
                    @error('surname')border-danger @enderror" wire:model.lazy="surname">
            @error('surname')
            <div id="surnameHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 mt-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control
                    @error('username')border-danger @enderror" wire:model.lazy="username">
            @error('username')
            <div id="usernameHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 mt-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control
                    @error('email')border-danger @enderror" wire:model.lazy="email">
            @error('email')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 mt-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control
                    @error('password')border-danger @enderror" wire:model.lazy="password">
            @error('password')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 mt-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control
                    @error('password_confirmation')border-danger @enderror">
            @error('password_confirmation')
            <div id="password_confirmationHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="col-12 mt-4">
                <input type="checkbox" name="terms" id="terms" class="form-check-input" required>
                <label for="terms" class="form-check-label">I agree to the
                    <a href="/terms-of-service" target="_blank">Terms of Service</a> and
                    <a href="/privacy-policy" target="_blank">Privacy policy</a></label>
            </div>
        @endif
        <div class="col-12 text-end mt-4">
            <a href="/login" class="me-2">Already registered?</a>
            <button type="submit">Register</button>
        </div>
    </form>
</div>
