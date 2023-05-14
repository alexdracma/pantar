<div class="container d-flex flex-column align-items-center position-absolute top-50 start-50 translate-middle">
    <div class="logo mb-3">
        <img src="assets/images/title.svg" class="img-fluid">
    </div>
{{--    method="post" action="{{ route('login') }}"  --}}
    <form wire:submit.prevent="login" class="p-3">

        <div class="col-12 mt-3">
            <label for="identity" class="form-label">Email or username</label>
            <input type="text" name="identity" id="identity" class="form-control
                    @error('identity')border-danger @enderror" wire:model.lazy="identity">
            @error('identity')
            <div id="identityHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 mt-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control
                    @error('password')border-danger @enderror" wire:model.lazy="password">
            @error('password')
            <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
{{-- To implement: remember me on login --}}
{{--        LOOK LARAVEL.COM AUTHENTICATION Auth::viaRemember()--}}
{{--        <div class="col-12 mt-4">--}}
{{--            <input type="checkbox" name="remember" id="remember" class="form-check-input">--}}
{{--            <label for="remember" class="form-check-label">Remember me</label>--}}
{{--        </div>--}}
        <div class="col-12 text-end mt-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="me-2">Forgot your password?</a>
            @endif

            <button type="submit">Login</button>
        </div>
    </form>
</div>
