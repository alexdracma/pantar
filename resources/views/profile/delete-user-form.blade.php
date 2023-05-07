<div>
    <button wire:click="confirmUserDeletion" wire:loading.attr="disabled">Delete Account</button>

    <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Delete Account') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

            <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                <x-input type="password" class="mt-1 block w-3/4 border-1 border-black"
                         autocomplete="current-password"
                         placeholder="{{ __('Password') }}"
                         x-ref="password"
                         wire:model.defer="password"
                         wire:keydown.enter="deleteUser" />

                <x-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">Cancel</button>
            <button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">Delete Account</button>
        </x-slot>
    </x-dialog-modal>
</div>
