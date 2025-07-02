<x-guest-layout>
   
      

        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        <form method="POST" action="{{ route('password.email') }}" class="form w-100">
                            @csrf
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">{{ __('Lupa Password?') }}</h1>
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ __('Masukkan email Anda dan kami akan mengirimkan link reset password.') }}
                                </div>
                            </div>
                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <x-validation-errors class="mb-4" />
                            <div class="fv-row mb-8">
                                <x-label for="email" value="{{ __('Email') }}" class="form-label" />
                                <x-input id="email" class="form-control bg-transparent" type="email"
                                    name="email" :value="old('email')" required autofocus autocomplete="username"
                                    placeholder="Email" />
                            </div>
                            <div class="d-grid mb-10">
                                <x-button class="btn btn-primary">
                                    {{ __('Kirim Link Reset Password') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
</x-guest-layout>
