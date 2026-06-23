<section>
    <header>
        <h2 style="font-size: 1.125rem; font-weight: 500; color: #1a202c;">
            {{ __('Profile Information') }}
        </h2>

        <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #718096;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="margin-top: 1.5rem;">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="form-control mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="form-control mt-1" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p style="font-size: 0.875rem; margin-top: 0.5rem; color: #2d3748;">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" style="text-decoration: underline; font-size: 0.875rem; color: #4a5568; background: none; border: none;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.5rem; font-weight: 500; font-size: 0.875rem; color: #e65100;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p id="saved-msg-profile" style="font-size: 0.875rem; color: #718096;">{{ __('Saved.') }}</p>
                <script>
                    setTimeout(function() {
                        var el = document.getElementById('saved-msg-profile');
                        if (el) el.style.display = 'none';
                    }, 2000);
                </script>
            @endif
        </div>
    </form>
</section>
