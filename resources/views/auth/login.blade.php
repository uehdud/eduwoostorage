<x-guest-layout>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
    </div>
    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
        <form class="form w-100" method="POST" action="{{ route('login') }}" id="kt_sign_in_form">
            @csrf
            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">{{ __('Masuk') }}</h1>
                <div class="text-gray-500 fw-semibold fs-6">
                    {{ __('Silakan login untuk melanjutkan') }}
                </div>
            </div>
            <x-validation-errors class="mb-4" />
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            <div class="fv-row mb-8">
                <x-label for="email" value="{{ __('Email') }}" class="form-label" />
                <x-input id="email" class="form-control bg-transparent" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
            </div>
            <div class="fv-row mb-3">
                <x-label for="password" value="{{ __('Password') }}" class="form-label" />
                <x-input id="password" class="form-control bg-transparent" type="password" name="password" required
                    autocomplete="current-password" placeholder="Password" />
            </div>
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div>
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="link-primary" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <div class="d-grid mb-10">
                <x-button class="btn btn-primary">
                    {{ __('Masuk') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>

