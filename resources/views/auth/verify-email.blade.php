<x-guest-layout>
    <div style="margin-bottom: 1rem; font-size: 0.875rem; color: #4a5568;">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div style="margin-bottom: 1rem; font-weight: 500; font-size: 0.875rem; color: #e65100;">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div style="margin-top: 1rem; display: flex; align-items: center; justify-content: space-between;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="text-decoration: underline; font-size: 0.875rem; color: #4a5568; background: none; border: none;">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
