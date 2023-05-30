<div class="text-left">
    <button wire:click="$toggle('changingPassword')">Change Password</button>

    <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model="changingPassword">

        <x-slot name="title">
            {{ __('Change your password') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="updatePassword">
                <div class="col-span-6 sm:col-span-4 mt-3">
                    <label for="password">Current Password</label>
                    <x-input id="current_password" type="password" class="mt-1 block w-full border-2 border-black" wire:model.defer="state.current_password" autocomplete="current-password" />
                    <x-input-error for="current_password" class="mt-2 text-danger" />
                </div>

                <div class="col-span-6 sm:col-span-4 mt-3">
                    <label for="password">New Password</label>
                    <x-input id="password" type="password" class="mt-1 block w-full border-2 border-black" wire:model.defer="state.password" autocomplete="new-password" />
                    <x-input-error for="password" class="mt-2 text-danger" />
                </div>

                <div class="col-span-6 sm:col-span-4 mt-3">
                    <label for="password">Confirm Password</label>
                    <x-input id="password_confirmation" type="password" class="mt-1 block w-full border-2 border-black" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                    <x-input-error for="password_confirmation" class="mt-2 text-danger" />

                </div>

                <div class="mt-5 d-flex justify-content-end">
                    <button wire:click="$toggle('changingPassword')" wire:loading.attr="disabled">Cancel</button>
                    <button type="submit" class="ms-3">Change Password</button>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer"></x-slot>

    </x-dialog-modal>
</div>
