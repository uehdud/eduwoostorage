<div>
    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!--begin::Wrapper-->
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <!--begin::Wrapper container-->
        <div class="app-container container-xxl d-flex flex-row flex-column-fluid">
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar"
                        class="app-toolbar align-items-center justify-content-between py-2 py-lg-4">
                        <!--begin::Toolbar wrapper-->
                        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2" id="kt_toolbar">
                            <!--begin::Page title-->
                            <div class="d-flex flex-column align-items-start me-3 gap-2">
                                <!--begin::Title-->
                                <h1 class="d-flex text-dark fw-bold m-0 fs-3">File Manager - Folders</h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600">
                                        <a href="../../demo22/dist/index.html"
                                            class="text-gray-600 text-hover-primary">Home</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600">File Manager</li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-500">Folders</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->

                        </div>
                        <!--end::Toolbar wrapper-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Card-->
                        <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10"
                            style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('assets/media/illustrations/sketchy-1/4.png')">
                            <!--begin::Card header-->
                            <div class="card-header pt-10">
                                <div class="d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="symbol symbol-circle me-5">
                                        <div
                                            class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                                            <i class="ki-duotone ki-abstract-47 fs-2x text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <div class="d-flex flex-column">
                                        <h2 class="mb-1">File Manager</h2>
                                        <div class="text-muted fw-bold">
                                            <span>Total Storage:
                                                {{ number_format(($totalSize ?? 0) / 1073741824, 2) }} GB / 50 GB
                                            </span>
                                            <span class="mx-3">|</span>
                                            <span>
                                                {{ $totalItems ?? 0 }} {{ ($totalItems ?? 0) == 1 ? 'item' : 'items' }}
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::Title-->
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pb-0">
                                <!--begin::Navs-->
                                <div class="d-flex overflow-auto h-55px">
                                    <ul
                                        class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-semibold flex-nowrap">
                                        <!--begin::Nav item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary me-6 active" href="#">Files</a>
                                        </li>
                                        <!--end::Nav item-->
                                        <!--begin::Nav item-->
                                        {{-- <li class="nav-item">
                                            <a class="nav-link text-active-primary me-6"
                                                href="../../demo22/dist/apps/file-manager/settings.html">Settings</a>
                                        </li> --}}
                                        <!--end::Nav item-->
                                    </ul>
                                </div>
                                <!--begin::Navs-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Card-->
                        <div class="card card-flush">
                            <!--begin::Card header-->
                            <div class="card-header pt-8">
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" wire:model.live="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="Search Files" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                                        <!--begin::Export-->
                                        {{-- <button type="button" class="btn btn-flex btn-light-primary me-3"
                                            id="kt_file_manager_new_folder" wire:click="$set('showFolderModal', true)">
                                            <i class="ki-duotone ki-add-folder fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Tambah Folder
                                        </button> --}}
                                        <!-- Modal Tambah Folder -->
                                        @if ($showFolderModal)
                                            <div class="modal fade show d-block" tabindex="-1"
                                                style="background:rgba(0,0,0,0.3)">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form wire:submit.prevent="createFolder">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Tambah Folder</h5>
                                                                <button type="button" class="btn-close"
                                                                    wire:click="$set('showFolderModal', false)"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="folderName" class="form-label">Nama
                                                                        Folder</label>
                                                                    <input type="text" id="folderName"
                                                                        class="form-control"
                                                                        wire:model.defer="folderName" required>
                                                                    @error('folderName')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                    wire:click="$set('showFolderModal', false)">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <!--end::Export-->
                                        <!--begin::Add customer-->
                                        <button type="button" class="btn btn-flex btn-primary mb-3"
                                            wire:click="$set('showUploadModal', true)">
                                            <i class="ki-duotone ki-folder-up fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Upload File
                                        </button>
                                        <!--end::Add customer-->
                                    </div>
                                    <!--end::Toolbar-->
                                    <!--begin::Group actions-->
                                    <div class="d-flex justify-content-end align-items-center d-none"
                                        data-kt-filemanager-table-toolbar="selected">
                                        <div class="fw-bold me-5">
                                            <span class="me-2"
                                                data-kt-filemanager-table-select="selected_count"></span>Selected
                                        </div>
                                        <button type="button" class="btn btn-danger"
                                            data-kt-filemanager-table-select="delete_selected">Delete Selected</button>
                                    </div>
                                    <!--end::Group actions-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body">
                                <!--begin::Table header-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Folder path-->
                                    <div class="badge badge-lg badge-light-primary">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <i class="ki-duotone ki-abstract-32 fs-2 text-primary me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            @if (isset($currentPath) && count($currentPath) > 0)
                                                @foreach ($currentPath as $i => $folder)
                                                    @if ($i > 0)
                                                        <i class="ki-duotone ki-right fs-2 text-primary mx-1"></i>
                                                    @endif
                                                    <a href="#"
                                                        wire:click.prevent="openFolder({{ $folder->id }})">{{ $folder->name }}</a>
                                                @endforeach
                                            @else
                                                <a href="#" wire:click.prevent="openRoot()">Home</a>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end::Folder path-->
                                    <!--begin::Folder Stats-->
                                    <div class="badge badge-lg badge-primary">
                                        <span id="kt_file_manager_items_counter">
                                            {{ $items->total() }} {{ $items->total() == 1 ? 'item' : 'items' }}
                                        </span>
                                    </div>
                                    <!--end::Folder Stats-->
                                </div>
                                <!--end::Table header-->
                                <!--begin::Table-->
                                <table id="kt_file_manager_list" data-kt-filemanager-table="folders"
                                    class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px pe-2">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        data-kt-check="true"
                                                        data-kt-check-target="#kt_file_manager_list .form-check-input"
                                                        value="1" />
                                                </div>
                                            </th>
                                            <th class="min-w-250px">Name</th>
                                            <th class="min-w-10px">Size</th>
                                            <th class="min-w-125px">Last Modified</th>
                                            <th class="w-125px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @if (isset($items) && $items->count())
                                            @foreach ($items as $item)
                                                @if ($item instanceof \App\Models\Folder)
                                                    <tr>
                                                        <td>
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $item->id }}" />
                                                            </div>
                                                        </td>
                                                        <td data-order="{{ $item->name }}">
                                                            <div class="d-flex align-items-center">
                                                                <span class="icon-wrapper">
                                                                    <i
                                                                        class="ki-duotone ki-folder fs-2x text-primary me-4">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </span>
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary">{{ $item->name }}</a>
                                                            </div>
                                                        </td>
                                                        <td>-</td>
                                                        <td>{{ $item->updated_at->format('Y-m-d H:i') }}</td>
                                                        <td class="text-end"
                                                            data-kt-filemanager-table="action_dropdown">
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Share link-->
                                                                <div class="ms-2"
                                                                    data-kt-filemanger-table="copy_link">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                                                        data-kt-menu-trigger="click"
                                                                        data-kt-menu-placement="bottom-end">
                                                                        <i class="ki-duotone ki-fasten fs-5 m-0">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </button>
                                                                    <!--begin::Menu-->
                                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px"
                                                                        data-kt-menu="true">
                                                                        <!--begin::Card-->
                                                                        <div class="card card-flush">
                                                                            <div class="card-body p-5">
                                                                                <!--begin::Loader-->
                                                                                <div class="d-flex"
                                                                                    data-kt-filemanger-table="copy_link_generator">
                                                                                    <!--begin::Spinner-->
                                                                                    <div class="me-5"
                                                                                        data-kt-indicator="on">
                                                                                        <span
                                                                                            class="indicator-progress">
                                                                                            <span
                                                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                    <!--end::Spinner-->
                                                                                    <!--begin::Label-->
                                                                                    <div class="fs-6 text-dark">
                                                                                        Generating
                                                                                        Share
                                                                                        Link...</div>
                                                                                    <!--end::Label-->
                                                                                </div>
                                                                                <!--end::Loader-->
                                                                                <!--begin::Link-->
                                                                                <div class="d-flex flex-column text-start d-none"
                                                                                    data-kt-filemanger-table="copy_link_result">
                                                                                    <div class="d-flex mb-3">
                                                                                        <i
                                                                                            class="ki-duotone ki-check fs-2 text-success me-3"></i>
                                                                                        <div class="fs-6 text-dark">
                                                                                            Share
                                                                                            Link
                                                                                            Generated</div>
                                                                                    </div>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        value="https://path/to/file/or/folder/" />
                                                                                    <div
                                                                                        class="text-muted fw-normal mt-2 fs-8 px-3">
                                                                                        Read only.
                                                                                        <a href="../../demo22/dist/apps/file-manager/settings/.html"
                                                                                            class="ms-2">Change
                                                                                            permissions</a>
                                                                                    </div>
                                                                                </div>
                                                                                <!--end::Link-->
                                                                            </div>
                                                                        </div>
                                                                        <!--end::Card-->
                                                                    </div>
                                                                    <!--end::Menu-->
                                                                    <!--end::Share link-->
                                                                </div>
                                                                <!--begin::More-->
                                                                <div class="ms-2 dropdown">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2 dropdown-toggle"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ki-duotone ki-dots-square fs-5 m-0">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                        </i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li>
                                                                            <a href="#"
                                                                                class="dropdown-item">View</a>
                                                                        </li>
                                                                        <li>
                                                                            @if (isset($item))
                                                                                <a href="#"
                                                                                    class="dropdown-item"
                                                                                    wire:click.prevent="showRenameModal({{ $item->id }}, '{{ addslashes($item->name) }}')">
                                                                                    Rename
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                        {{-- <li>
                                                                        <a href="#" class="dropdown-item"
                                                                            wire:click.prevent="showMoveModal({{ $item->id }})"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_move_to_folder">
                                                                            Move to folder
                                                                        </a>
                                                                    </li> --}}
                                                                        <li>
                                                                            <a href="#"
                                                                                class="dropdown-item text-danger"
                                                                                onclick="confirmDeleteFolder({{ $item->id }})">
                                                                                Delete
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!--end::More-->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @elseif ($item instanceof \App\Models\File)
                                                    <tr>
                                                        <td>
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="file-{{ $item->id }}" />
                                                            </div>
                                                        </td>
                                                        <td data-order="{{ $item->name }}">
                                                            <div class="d-flex align-items-center">
                                                                <span class="icon-wrapper">
                                                                    <i class="ki-duotone ki-file fs-2x text-info me-4">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </span>
                                                                <a href="{{ asset('storage/' . $item->path) }}"
                                                                    target="_blank"
                                                                    class="text-gray-800 text-hover-primary">
                                                                    {{ $item->name ?? $item->original_name }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ number_format($item->size / 1048576, 2) }} MB
                                                        </td>
                                                        <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                                        <td class="text-end"
                                                            data-kt-filemanager-table="action_dropdown">
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Share link-->
                                                                <div class="ms-2"
                                                                    data-kt-filemanger-table="copy_link">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                                                        data-kt-menu-trigger="click"
                                                                        data-kt-menu-placement="bottom-end">
                                                                        <i class="ki-duotone ki-fasten fs-5 m-0">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </button>
                                                                    <!--begin::Menu-->
                                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px"
                                                                        data-kt-menu="true">
                                                                        <!--begin::Card-->
                                                                        <div class="card card-flush">
                                                                            <div class="card-body p-5">
                                                                                <!--begin::Loader-->
                                                                                <div class="d-flex"
                                                                                    data-kt-filemanger-table="copy_link_generator">
                                                                                    <!--begin::Spinner-->
                                                                                    <div class="me-5"
                                                                                        data-kt-indicator="on">
                                                                                        <span
                                                                                            class="indicator-progress">
                                                                                            <span
                                                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                    <!--end::Spinner-->
                                                                                    <!--begin::Label-->
                                                                                    <div class="fs-6 text-dark">
                                                                                        Generating
                                                                                        Share
                                                                                        Link...</div>
                                                                                    <!--end::Label-->
                                                                                </div>
                                                                                <!--end::Loader-->
                                                                                <!--begin::Link-->
                                                                                <div class="d-flex flex-column text-start d-none"
                                                                                    data-kt-filemanger-table="copy_link_result">
                                                                                    <div class="d-flex mb-3">
                                                                                        <i
                                                                                            class="ki-duotone ki-check fs-2 text-success me-3"></i>
                                                                                        <div class="fs-6 text-dark">
                                                                                            Share
                                                                                            Link
                                                                                            Generated</div>
                                                                                    </div>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        value="https://path/to/file/or/folder/" />
                                                                                    <div
                                                                                        class="text-muted fw-normal mt-2 fs-8 px-3">
                                                                                        Read only.
                                                                                        <a href="../../demo22/dist/apps/file-manager/settings/.html"
                                                                                            class="ms-2">Change
                                                                                            permissions</a>
                                                                                    </div>
                                                                                </div>
                                                                                <!--end::Link-->
                                                                            </div>
                                                                        </div>
                                                                        <!--end::Card-->
                                                                    </div>
                                                                    <!--end::Menu-->
                                                                    <!--end::Share link-->
                                                                </div>
                                                                <!--begin::More-->
                                                                <div class="ms-2 dropdown">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2 dropdown-toggle"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ki-duotone ki-dots-square fs-5 m-0">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                        </i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        {{-- <li>
                                                                            <a href="#"
                                                                                class="dropdown-item">View</a>
                                                                        </li> --}}
                                                                        <li>
                                                                            @if (isset($item))
                                                                                <a href="#"
                                                                                    class="dropdown-item"
                                                                                    wire:click.prevent="showRenameModalFile({{ $item->id }}, '{{ addslashes($item->name) }}')">
                                                                                    Rename
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                        {{-- <li>
                                                                            <a href="#" class="dropdown-item"
                                                                                wire:click.prevent="showMoveModal({{ $item->id }})"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_move_to_folder">
                                                                                Move to folder
                                                                            </a>
                                                                        </li> --}}
                                                                        <li>
                                                                            <a href="#"
                                                                                class="dropdown-item text-danger"
                                                                                onclick="confirmDeleteFile({{ $item->id }})">
                                                                                Delete
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!--end::More-->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada data
                                                    ditemukan.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <!--end::Table-->

                                {{-- PAGINATION --}}
                                <div class="mt-4 d-flex justify-content-end align-items-center">
                                    <div>
                                        {{-- Pastikan Livewire bisa track perubahan halaman --}}
                                        {{ $items->links('pagination::bootstrap-5') }}

                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Upload template-->
                        <table class="d-none">
                            <tr id="kt_file_manager_new_folder_row" data-kt-filemanager-template="upload">
                                <td></td>
                                <td id="kt_file_manager_add_folder_form" class="fv-row">
                                    <div class="d-flex align-items-center">
                                        <!--begin::Folder icon-->
                                        <span id="kt_file_manager_folder_icon">
                                            <i class="ki-duotone ki-folder fs-2x text-primary me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <!--end::Folder icon-->
                                        <!--begin:Input-->
                                        <input type="text" name="new_folder_name"
                                            placeholder="Enter the folder name" class="form-control mw-250px me-3" />
                                        <!--end:Input-->
                                        <!--begin:Submit button-->
                                        <button class="btn btn-icon btn-light-primary me-3"
                                            id="kt_file_manager_add_folder">
                                            <span class="indicator-label">
                                                <i class="ki-duotone ki-check fs-1"></i>
                                            </span>
                                            <span class="indicator-progress">
                                                <span class="spinner-border spinner-border-sm align-middle"></span>
                                            </span>
                                        </button>
                                        <!--end:Submit button-->
                                        <!--begin:Cancel button-->
                                        <button class="btn btn-icon btn-light-danger" <span class="indicator-label">
                                            <i class="ki-duotone ki-cross fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            </span>
                                            <span class="indicator-progress">
                                                <span class="spinner-border spinner-border-sm align-middle"></span>
                                            </span>
                                        </button>
                                        <!--end:Cancel button-->
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <!--end::Upload template-->
                        <!--begin::Rename template-->
                        <div class="d-none" data-kt-filemanager-template="rename">
                            <div class="fv-row">
                                <div class="d-flex align-items-center">
                                    <span id="kt_file_manager_rename_folder_icon"></span>
                                    <input type="text" id="kt_file_manager_rename_input" name="rename_folder_name"
                                        placeholder="Enter the new folder name" class="form-control mw-250px me-3"
                                        value="" />
                                    <button class="btn btn-icon btn-light-primary me-3"
                                        id="kt_file_manager_rename_folder">
                                        <i class="ki-duotone ki-check fs-1"></i>
                                    </button>
                                    <button class="btn btn-icon btn-light-danger"
                                        id="kt_file_manager_rename_folder_cancel">
                                        <span class="indicator-label">
                                            <i class="ki-duotone ki-cross fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="indicator-progress">
                                            <span class="spinner-border spinner-border-sm align-middle"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end::Rename template-->
                        <!--begin::Action template-->
                        <div class="d-none" data-kt-filemanager-template="action">
                            <div class="d-flex justify-content-end">
                                <!--begin::Share link-->
                                <div class="ms-2" data-kt-filemanger-table="copy_link">
                                    <button type="button"
                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-fasten fs-5 m-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px"
                                        data-kt-menu="true">
                                        <!--begin::Card-->
                                        <div class="card card-flush">
                                            <div class="card-body p-5">
                                                <!--begin::Loader-->
                                                <div class="d-flex" data-kt-filemanger-table="copy_link_generator">
                                                    <!--begin::Spinner-->
                                                    <div class="me-5" data-kt-indicator="on">
                                                        <span class="indicator-progress">
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </div>
                                                    <!--end::Spinner-->
                                                    <!--begin::Label-->
                                                    <div class="fs-6 text-dark">Generating Share Link...</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Loader-->
                                                <!--begin::Link-->
                                                <div class="d-flex flex-column text-start d-none"
                                                    data-kt-filemanger-table="copy_link_result">
                                                    <div class="d-flex mb-3">
                                                        <i class="ki-duotone ki-check fs-2 text-success me-3"></i>
                                                        <div class="fs-6 text-dark">Share Link Generated</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="https://path/to/file/or/folder/" />
                                                    <div class="text-muted fw-normal mt-2 fs-8 px-3">Read only.
                                                        <a href="../../demo22/dist/apps/file-manager/settings/.html"
                                                            class="ms-2">Change permissions</a>
                                                    </div>
                                                </div>
                                                <!--end::Link-->
                                            </div>
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Share link-->
                                <!--begin::More-->
                                <div class="ms-2">
                                    <button type="button"
                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-dots-square fs-5 m-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Download File</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            @if (isset($item))
                                                <a href="#" class="menu-link px-3"
                                                    wire:click.prevent="showRenameModal({{ $item->id }}, '{{ addslashes($item->name) }}')"
                                                    data-kt-filemanager-table="rename">Rename</a>
                                            @endif
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            @if (isset($item))
                                                <a href="#" class="menu-link px-3"
                                                    wire:click.prevent="showMoveModal({{ $item->id }})"
                                                    data-kt-filemanager-table-filter="move_row" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_move_to_folder">Move to folder</a>
                                            @endif
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            @if (isset($item))
                                                <a href="#" class="menu-link text-danger px-3"
                                                    onclick="confirmDeleteFolder({{ $item->id }})"
                                                    data-kt-filemanager-table-filter="delete_row">Delete</a>
                                            @endif
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::More-->
                            </div>
                        </div>
                        <!--end::Action template-->
                        <!--begin::Checkbox template-->
                        <div class="d-none" data-kt-filemanager-template="checkbox">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </div>
                        <!--end::Checkbox template-->
                        <!--begin::Modals-->
                        <!--begin::Modal - Upload File-->
                        <div class="modal fade" id="kt_modal_upload" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Form-->
                                    <form class="form" action="none" id="kt_modal_upload_form">
                                        <!--begin::Modal header-->
                                        <div class="modal-header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Upload files</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
                                        <!--begin::Modal body-->
                                        <div class="modal-body pt-10 pb-15 px-lg-17">
                                            <!--begin::Input group-->
                                            <div class="form-group">
                                                <!--begin::Dropzone-->
                                                <div class="dropzone dropzone-queue mb-2"
                                                    id="kt_modal_upload_dropzone">
                                                    <!--begin::Controls-->
                                                    <div class="dropzone-panel mb-4">
                                                        <a class="dropzone-select btn btn-sm btn-primary me-2">Attach
                                                            files</a>
                                                        <a class="dropzone-upload btn btn-sm btn-light-primary me-2">Upload
                                                            All</a>
                                                        <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove
                                                            All</a>
                                                    </div>
                                                    <!--end::Controls-->
                                                    <!--begin::Items-->
                                                    <div class="dropzone-items wm-200px">
                                                        <div class="dropzone-item p-5" style="display:none">
                                                            <!--begin::File-->
                                                            <div class="dropzone-file">
                                                                <div class="dropzone-filename text-dark"
                                                                    title="some_image_file_name.jpg">
                                                                    <span
                                                                        data-dz-name="">some_image_file_name.jpg</span>
                                                                    <strong>(
                                                                        <span data-dz-size="">340kb</span>)</strong>
                                                                </div>
                                                                <div class="dropzone-error mt-0"
                                                                    data-dz-errormessage=""></div>
                                                            </div>
                                                            <!--end::File-->
                                                            <!--begin::Progress-->
                                                            <div class="dropzone-progress">
                                                                <div class="progress bg-gray-300">
                                                                    <div class="progress-bar bg-primary"
                                                                        role="progressbar" aria-valuemin="0"
                                                                        aria-valuemax="100" aria-valuenow="0"
                                                                        data-dz-uploadprogress=""></div>
                                                                </div>
                                                            </div>
                                                            <!--end::Progress-->
                                                            <!--begin::Toolbar-->
                                                            <div class="dropzone-toolbar">
                                                                <span class="dropzone-start">
                                                                    <i class="ki-duotone ki-to-right fs-1"></i>
                                                                </span>
                                                                <span class="dropzone-cancel" data-dz-remove=""
                                                                    style="display: none;">
                                                                    <i class="ki-duotone ki-cross fs-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </span>
                                                                <span class="dropzone-delete" data-dz-remove="">
                                                                    <i class="ki-duotone ki-cross fs-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </span>
                                                            </div>
                                                            <!--end::Toolbar-->
                                                        </div>
                                                    </div>
                                                    <!--end::Items-->
                                                </div>
                                                <!--end::Dropzone-->
                                                <!--begin::Hint-->

                                                <!--end::Hint-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Modal body-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                            </div>
                        </div>
                        <!--end::Modal - Upload File-->

                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->

            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper container-->
    </div>
    <!--end::Wrapper-->{{-- Modal Rename Folder --}}
    @if ($renameFolderId)
        <div class="modal fade show" tabindex="-1" style="display:block; background:rgba(0,0,0,0.3)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="renameFolder">
                        <div class="modal-header">
                            <h5 class="modal-title">Rename Folder</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('renameFolderId', null)"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="renameFolderName" class="form-label">Nama Folder Baru</label>
                                <input type="text" id="renameFolderName" class="form-control"
                                    wire:model.defer="renameFolderName" required autofocus>
                                @error('renameFolderName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light"
                                wire:click="$set('renameFolderId', null)">Batal</button>
                            <button type="submit" class="btn btn-primary">Rename</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($deleteFolderId)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.3)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Folder</h5>
                        <button type="button" class="btn-close" wire:click="$set('deleteFolderId', null)"></button>
                    </div>
                    <div class="modal-body">
                        Yakin ingin menghapus folder ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            wire:click="$set('deleteFolderId', null)">Batal</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteFolder">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($moveFolderId)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.3)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="moveFolder(selectedParentId)">
                        <div class="modal-header">
                            <h5 class="modal-title">Pindahkan Folder</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('moveFolderId', null)"></button>
                        </div>
                        <div class="modal-body">
                            <select class="form-select" wire:model="selectedParentId" required>
                                <option value="">Pilih folder tujuan</option>
                                @foreach ($items as $f)
                                    @if ($f->id !== $moveFolderId)
                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light"
                                wire:click="$set('moveFolderId', null)">Batal</button>
                            <button type="submit" class="btn btn-primary">Pindahkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Upload File Modal --}}
    @if ($showUploadModal ?? false)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.3)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="uploadFiles">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload File</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('showUploadModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <input type="file" wire:model="files" multiple class="form-control" />
                            @error('files.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            {{-- Ukuran total file --}}
                            @if (!empty($files) && count($files) > 0)
                                <div class="mt-2">
                                    <small>
                                        Total file:
                                        <span>
                                            {{ number_format(collect($files)->sum(fn($f) => $f->getSize()) / 1048576, 2) }}
                                            MB
                                        </span>
                                    </small>
                                </div>
                            @endif

                            {{-- Progress Bar --}}
                            <div class="mt-3">
                                <div id="upload-progress-bar" class="progress" style="height: 20px;">
                                    <div id="upload-progress-bar-inner"
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar"
                                        style="width: {{ $uploadProgress }}%; transition: width 0.4s cubic-bezier(.4,2,.6,1);"
                                        aria-valuenow="{{ $uploadProgress }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $uploadProgress }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light"
                                wire:click="$set('showUploadModal', false)">Batal</button>
                            <button type="submit" class="btn btn-primary"
                                wire:loading.attr="disabled">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($renameFileId)
        <div class="modal fade show" tabindex="-1" style="display:block; background:rgba(0,0,0,0.3)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="renameFile">
                        <div class="modal-header">
                            <h5 class="modal-title">Rename File</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('renameFileId', null)"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="renameFileName" class="form-label">Nama File Baru</label>
                                <input type="text" id="renameFileName" class="form-control"
                                    wire:model.defer="renameFileName" required autofocus>
                                @error('renameFileName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light"
                                wire:click="$set('renameFileId', null)">Batal</button>
                            <button type="submit" class="btn btn-primary">Rename</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Pastikan Livewire v3: gunakan window.Livewire, bukan Livewire.emit
            window.confirmDeleteFolder = function(folderId) {

                Swal.fire({
                    title: 'Yakin ingin menghapus folder ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan dispatch jika Livewire v3, emit jika v2
                        Livewire.dispatch('deleteFolderSwal', {
                            id: folderId
                        });
                    }
                });
            }

            window.confirmDeleteFile = function(fileId) {
                Swal.fire({
                    title: 'Yakin ingin menghapus file ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteFileSwal', {
                            id: fileId
                        });
                    }
                });
            }

            // Scroll ke atas tabel saat ganti halaman paginasi
            document.addEventListener('livewire:navigated', function() {
                const table = document.getElementById('kt_file_manager_list');
                if (table) {
                    table.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });

            // Share link generation
            document.querySelectorAll('[data-kt-filemanger-table="copy_link"] button').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    var tr = btn.closest('tr');
                    var isFolder = tr && tr.querySelector('i.ki-folder');
                    var isFile = tr && tr.querySelector('i.ki-file');
                    var id = null,
                        type = null;
                    if (isFolder) {
                        id = tr.querySelector('input[type="checkbox"]').value;
                        type = 'folder';
                    } else if (isFile) {
                        id = tr.querySelector('input[type="checkbox"]').value.replace('file-', '');
                        type = 'file';
                    }
                    if (!id || !type) return;

                    var loader = tr.querySelector('[data-kt-filemanger-table="copy_link_generator"]');
                    var result = tr.querySelector('[data-kt-filemanger-table="copy_link_result"]');
                    loader.classList.remove('d-none');
                    result.classList.add('d-none');

                    fetch('{{ route('share.generate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                type: type,
                                id: id
                            })
                        })
                        .then(res => res.json())
                        .then(function(data) {
                            loader.classList.add('d-none');
                            result.classList.remove('d-none');
                            result.querySelector('input').value = data.url;
                        })
                        .catch(function() {
                            loader.classList.add('d-none');
                            result.classList.remove('d-none');
                            result.querySelector('input').value = 'Failed to generate link';
                        });
                });
            });
        </script>
    @endpush
</div>
</div>
