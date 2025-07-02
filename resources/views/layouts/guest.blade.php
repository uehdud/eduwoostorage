<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Stylesheets (replace with your own if needed) -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @livewireStyles
    <!-- Metronic Styles (optional, if you use them) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                background-image: url("assets/media/auth/bg10.jpeg");
            }

            [data-bs-theme="dark"] body {
                background-image: url("assets/media/auth/bg10-dark.jpeg");
            }
        </style>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <!-- Aside Section -->
                    <div class="d-flex flex-lg-row-fluid">
                        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                            <!--begin::Image-->
                            <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                                src="{{ asset('assets/media/auth/agency.png') }}" alt="" />
                            <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                                src="{{ asset('assets/media/auth/agency-dark.png') }}" alt="" />
                            <!--end::Image-->
                            <!--begin::Title-->
                            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
                                Eduwoo Storage
                            </h1>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="text-gray-600 fs-base text-center fw-semibold">
                                Tempat penyimpanan dokumen dan galeri file Anda secara aman dan mudah diakses kapan
                                saja.
                            </div>
                            <!--end::Text-->
                        </div>
                    </div>
                    <!-- End Aside Section -->
                </div>
            </div>
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        {{-- Slot for authentication content --}}
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/js/custom/authentication/sign-in/general.js"></script>
</body>

</html>
