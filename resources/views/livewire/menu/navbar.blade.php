<div>
    <!--begin::Header-->
    <div id="kt_app_header" class="app-header">
        <!--begin::Header primary-->
        <div class="app-header-primary">
            <!--begin::Header primary container-->
            <div class="app-container container-xxl d-flex align-items-stretch justify-content-between">
                <!--begin::Logo and search-->
                <div class="d-flex flex-stack align-items-stretch flex-grow-1 flex-lg-grow-0">
                    <!--begin::Logo wrapper-->
                    <div class="d-flex align-items-center me-7">
                        <!--begin::Header secondary toggle-->
                        <button
                            class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 ms-n3 me-2"
                            id="kt_header_secondary_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                        <!--end::Header secondary toggle-->
                        <!--begin::Logo-->
                        <a href="#" class="d-flex align-items-center">
                            <img alt="Logo" src="{{ asset('assets/media/logos/demo22.png') }}"
                                class="h-25px h-lg-30px" />
                        </a>
                        <!--end::Logo-->
                    </div>
                    <!--end::Logo wrapper-->
                </div>
                <!--end::Logo and search-->
                <!--begin::Navbar-->
                <div class="app-navbar gap-2">
                    <!--begin::Activities-->
                    <div class="app-navbar-item">
                        <div class="btn btn-icon btn-color-white btn-custom bg-hover-white bg-hover-opacity-10"
                            id="kt_activities_toggle">
                            <i class="ki-duotone ki-chart-simple fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </div>
                    </div>
                    <!--end::Activities-->
                    <!--begin::Chat-->
                    <div class="app-navbar-item">
                        <div class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 lh-1 position-relative"
                            id="kt_drawer_chat_toggle">
                            <i class="ki-duotone ki-message-text-2 fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <span
                                class="bullet bullet-dot bg-white h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
                        </div>
                    </div>
                    <!--end::Chat-->
                    <!--begin::Theme mode-->
                    <div class="app-navbar-item">
                        <a href="#" class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10"
                            data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-night-day theme-light-show fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                                <span class="path7"></span>
                                <span class="path8"></span>
                                <span class="path9"></span>
                                <span class="path10"></span>
                            </i>
                            <i class="ki-duotone ki-moon theme-dark-show fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                            data-kt-menu="true" data-kt-element="theme-mode-menu">
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                    data-kt-value="light">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-duotone ki-night-day fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                            <span class="path6"></span>
                                            <span class="path7"></span>
                                            <span class="path8"></span>
                                            <span class="path9"></span>
                                            <span class="path10"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Light</span>
                                </a>
                            </div>
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                    data-kt-value="dark">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-duotone ki-moon fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Dark</span>
                                </a>
                            </div>
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                    data-kt-value="system">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-duotone ki-screen fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">System</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end::Theme mode-->
                    <!--begin::User-->
                    <div class="app-navbar-item" id="kt_header_user_menu_toggle">
                        <div class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 ps-3 pe-1"
                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <div
                                class="d-none d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4">
                                <span
                                    class="text-white fs-8 fw-bold lh-1 mb-1">{{ Auth::user()->name ?? 'User' }}</span>
                                <span
                                    class="text-white fs-8 opacity-75 fw-semibold lh-1">{{ Auth::user()->email ?? '' }}</span>
                            </div>
                            <div class="symbol symbol-30px symbol-md-40px">
                                <img src="{{ asset('assets/media/avatars/300-1.jpg') }}" alt="image" />
                            </div>
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="{{ asset('assets/media/avatars/300-1.jpg') }}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">
                                            {{ Auth::user()->name ?? 'User' }}</div>
                                        <a href="#"
                                            class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email ?? '' }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-2"></div>
                            <div class="menu-item px-5">
                                <a href="#" class="menu-link px-5">My Profile</a>
                            </div>
                            <div class="menu-item px-5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="menu-link px-5 w-100 text-start bg-transparent border-0">
                                        {{ __('Sign Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::User -->
                </div>
                <!--end::Navbar-->
            </div>
            <!--end::Header primary container-->
        </div>
        <!--end::Header primary-->
    </div>
    <!--end::Header-->
</div>
