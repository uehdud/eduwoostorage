<x-guest-layout>


    <!--begin::Body-->
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                    {{-- <form method="POST" action="{{ route('register') }}" class="form w-100">
                            @csrf
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">{{ __('Daftar') }}</h1>
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ __('Buat akun baru untuk mulai menggunakan Eduwoo Storage') }}
                                </div>
                            </div>
                            <x-validation-errors class="mb-4" />
                            <div class="fv-row mb-8">
                                <x-label for="name" value="{{ __('Nama') }}" class="form-label" />
                                <x-input id="name" class="form-control bg-transparent" type="text"
                                    name="name" :value="old('name')" required autofocus autocomplete="name"
                                    placeholder="Nama" />
                            </div>
                            <div class="fv-row mb-8">
                                <x-label for="email" value="{{ __('Email') }}" class="form-label" />
                                <x-input id="email" class="form-control bg-transparent" type="email"
                                    name="email" :value="old('email')" required autocomplete="username"
                                    placeholder="Email" />
                            </div>
                            <div class="fv-row mb-8">
                                <x-label for="password" value="{{ __('Password') }}" class="form-label" />
                                <x-input id="password" class="form-control bg-transparent" type="password"
                                    name="password" required autocomplete="new-password" placeholder="Password" />
                            </div>
                            <div class="fv-row mb-8">
                                <x-label for="password_confirmation" value="{{ __('Konfirmasi Password') }}"
                                    class="form-label" />
                                <x-input id="password_confirmation" class="form-control bg-transparent" type="password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Konfirmasi Password" />
                            </div>
                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="fv-row mb-8">
                                    <x-label for="terms">
                                        <div class="flex items-center">
                                            <x-checkbox name="terms" id="terms" required />
                                            <div class="ms-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' =>
                                                        '<a target="_blank" href="' .
                                                        route('terms.show') .
                                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Terms of Service') .
                                                        '</a>',
                                                    'privacy_policy' =>
                                                        '<a target="_blank" href="' .
                                                        route('policy.show') .
                                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Privacy Policy') .
                                                        '</a>',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </x-label>
                                </div>
                            @endif
                            
                            <div class="d-grid mb-10">
                                <x-button class="btn btn-primary">
                                    {{ __('Daftar') }}
                                </x-button>
                            </div>
                        </form> --}}
                    <h5>Hubungi Admin untuk mendapatkan akses</h5>
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <a class="link-primary" href="{{ route('login') }}">
                            {{ __('Sudah punya akun? Masuk') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Body-->

</x-guest-layout>
