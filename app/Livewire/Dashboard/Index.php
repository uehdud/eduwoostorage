<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\Folder;
use App\Models\File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithFileUploads, WithPagination;
    #[Url]
    public ?int $page = 1;
    public $showFolderModal = false;
    public $folderName = '';
    public $renameFolderId = null;
    public $renameFolderName = '';
    public $moveFolderId = null;
    public $deleteFolderId = null;
    public $files = [];
    public $showUploadModal = false;
    public $uploadProgress = 0;
    public $filesWithoutFolder = [];
    public $search = '';
    public $perPage = 10;
    public $renameFileId = null;
    public $renameFileName = '';

    public function mount()
    {
        $this->filesWithoutFolder = File::whereNull('folder_id')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function createFolder()
    {
        try {
            DB::transaction(function () {
                $this->validate([
                    'folderName' => 'required|string|max:255',
                ]);
                Folder::create([
                    'name' => $this->folderName,
                    'user_id' => auth()->id(),
                    'parent_id' => $this->parentId ?? null,
                ]);
            });
            $this->reset(['showFolderModal', 'folderName']);
            session()->flash('success', 'Folder berhasil dibuat.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal membuat folder.');
            // report($e);
        }
    }



    public function showRenameModal($id, $name)
    {
        $this->renameFolderId = $id;
        $this->renameFolderName = $name;
    }
    public function showRenameModalFile($id, $name)
    {
        $this->renameFileId = $id;
        $this->renameFileName = $name;
    }

    public function renameFolder()
    {
        $this->validate([
            'renameFolderName' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () {
                $folder = Folder::where('id', $this->renameFolderId)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($folder) {
                    $folder->name = $this->renameFolderName;
                    $folder->save();
                }
            });
            $this->reset(['renameFolderId', 'renameFolderName']);
            session()->flash('success', 'Folder berhasil diubah.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal mengubah folder.');
            // report($e);
        }
    }

    public function renameFile()
    {
        $this->validate([
            'renameFileName' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () {
                $file = File::where('id', $this->renameFileId)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($file) {
                    $file->name = $this->renameFileName;
                    $file->save();
                }
            });
            $this->reset(['renameFileId', 'renameFileName']);
            session()->flash('success', 'File berhasil diubah.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal mengubah file.');
            // report($e);
        }
    }

    public function showMoveModal($id)
    {
        $this->moveFolderId = $id;
    }

    public function moveFolder($newParentId)
    {
        try {
            DB::transaction(function () use ($newParentId) {
                Folder::where('id', $this->moveFolderId)
                    ->where('user_id', auth()->id())
                    ->first()?->update(['parent_id' => $newParentId]);
            });
            $this->reset('moveFolderId');
            session()->flash('success', 'Folder berhasil dipindahkan.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal memindahkan folder.');
            // report($e);
        }
    }

    #[On('deleteFileSwal')]
    public function deleteFileSwal($id)
    {


        try {
            DB::transaction(function () use ($id) {
                $file = File::where('id', $id)->where('user_id', auth()->id())->first();
                if ($file) {
                    Storage::disk('public')->delete($file->path);
                    $file->delete();
                    $this->filesWithoutFolder = File::whereNull('folder_id')
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->get();
                    session()->flash('success', 'File berhasil dihapus.');
                }
            });
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menghapus file.');
        }
    }

    #[On('deleteFolderSwal')]
    public function deleteFolderSwal($id)
    {


        try {
            DB::transaction(function () use ($id) {
                $folder = Folder::where('id', $id)->where('user_id', auth()->id())->first();
                if ($folder) {
                    foreach ($folder->files as $file) {
                        Storage::disk('public')->delete($file->path);
                        $file->delete();
                    }
                    $folder->delete();
                    $this->folders = Folder::where('user_id', auth()->id())->get();
                    $this->filesWithoutFolder = File::whereNull('folder_id')
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->get();
                    session()->flash('success', 'Folder berhasil dihapus.');
                }
            });
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menghapus folder.');
        }
    }

    public function uploadFiles()
    {
        $this->validate([
            'files.*' => 'required|file|max:1024000', // Maksimal 1GB per file
        ]);

        try {
            DB::transaction(function () {
                foreach ($this->files as $file) {
                    $path = $file->store('uploads', 'public');
                    File::create([
                        'name'          => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type'     => $file->getMimeType(),
                        'size'          => $file->getSize(),
                        'path'          => $path,
                        'folder_id'     => $this->currentFolderId ?? null,
                        'user_id'       => auth()->id(),
                        'views'         => 0,
                    ]);
                }
            });

            // Refresh data table
            $this->folders = Folder::where('user_id', auth()->id())->get();
            $this->filesWithoutFolder = File::whereNull('folder_id')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();

            $this->reset(['files', 'showUploadModal', 'uploadProgress']);
            session()->flash('success', 'File berhasil diupload.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal upload file.');
            // report($e);
        }
    }

    public function updatedFiles()
    {
        $this->uploadProgress = 0;
    }

    public function getListeners()
    {
        return [
            'livewire-upload-progress' => 'onUploadProgress',
        ];
    }

    public function onUploadProgress($progress)
    {
        $this->uploadProgress = $progress;
    }

    public function deleteFile($id)
    {
        $file = File::where('id', $id)->where('user_id', auth()->id())->first();
        if ($file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
            $this->filesWithoutFolder = File::whereNull('folder_id')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
            session()->flash('success', 'File berhasil dihapus.');
        }
    }

    #[On('upload-finished')]
    public function uploadFinished($payload)
    {
        $this->showUploadModal = false;
        $this->reset(['files', 'uploadProgress']);
        // Refresh data table
        $this->folders = Folder::where('user_id', auth()->id())->get();
        $this->filesWithoutFolder = File::whereNull('folder_id')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        session()->flash('success', 'File berhasil diupload: ' . ($payload['filename'] ?? ''));
    }

    #[On('close-upload-modal')]
    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->reset(['files', 'uploadProgress']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = auth()->id();

        $folders = Folder::where('user_id', $userId)
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->get();

        $files = File::whereNull('folder_id')
            ->where('user_id', $userId)
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('original_name', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        $items = $folders->concat($files)->sortByDesc(
            fn($item) =>
            $item instanceof Folder ? $item->updated_at : $item->created_at
        )->values();

        $paginated = new LengthAwarePaginator(
            $items->forPage($this->page, $this->perPage),
            $items->count(),
            $this->perPage,
            $this->page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Hitung total size semua file user (bisa tanpa filter search)
        $totalSize = File::where('user_id', $userId)->sum('size');
        $totalItems = Folder::where('user_id', $userId)->count() + File::where('user_id', $userId)->count();

        return view('livewire.dashboard.index', [
            'items' => $paginated,
            'totalSize' => $totalSize,
            'totalItems' => $totalItems,
        ]);
    }
}
