<?php

use App\Concerns\ProfileValidationRules;
use App\Traits\UserPhotoFileStorage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules, WithFileUploads, UserPhotoFileStorage;

    public string $name = '';
    public string $email = '';
    public string $gender = '';
    public $photo = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name   = $user->name;
        $this->email  = $user->email;
        $this->gender = $user->gender;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            ...$this->profileRules($user->id),
            'gender' => ['required', 'in:M,F'],
            'photo'  => ['nullable', 'mimes:jpg,jpeg,png,webp,gif,avif', 'max:4096'],
        ]);

        if ($this->photo) {
            $this->deleteUserPhoto($user);
            $this->storeUserPhoto($this->photo, $user);
        }

        $user->fill([
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'gender' => $validated['gender'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->photo = null;

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name, email, gender and photo')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full">

            <div class="flex gap-10 items-start">

                {{-- Left: text fields --}}
                <div class="flex-1 space-y-6">
                    <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                    <div>
                        <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                        @if ($this->hasUnverifiedEmail)
                            <div>
                                <flux:text class="mt-4">
                                    {{ __('Your email address is unverified.') }}
                                    <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </flux:link>
                                </flux:text>
                            </div>
                        @endif
                    </div>

                    <flux:radio.group wire:model="gender" :label="__('Gender')">
                        <flux:radio value="M" :label="__('Male')" />
                        <flux:radio value="F" :label="__('Female')" />
                    </flux:radio.group>
                </div>

                {{-- Right: photo --}}
                <div class="flex flex-col items-center gap-3 shrink-0 pt-1">
                    <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300 self-start">{{ __('Photo') }}</p>

                    @if ($photo)
                        <img
                            src="{{ $photo->temporaryUrl() }}"
                            alt="Preview"
                            class="size-24 rounded-full object-cover ring-2 ring-amber-400"
                        />
                    @else
                        <flux:avatar
                            size="xl"
                            :name="auth()->user()->name"
                            :src="auth()->user()->photo_full_url"
                        />
                    @endif

                    <label class="cursor-pointer text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-amber-500 dark:hover:text-amber-400 transition-colors">
                        {{ $photo ? __('Change again') : __('Upload photo') }}
                        <input type="file" wire:model="photo" accept="image/jpeg,image/png,image/webp,image/gif,image/avif" class="sr-only" />
                    </label>

                    <div wire:loading wire:target="photo" class="text-xs text-zinc-400">{{ __('Uploading…') }}</div>

                    <flux:error name="photo" />
                </div>

            </div>

            <div class="mt-6 flex items-center gap-4">
                <flux:button variant="primary" type="submit" data-test="update-profile-button">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif
    </x-pages::settings.layout>
</section>