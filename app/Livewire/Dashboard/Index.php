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
    public $moveFileId = null;
    public $copyFileId = null;
    public $targetFolderId = null;
    public $currentFolderId = null;
    public $currentFolder = null;
    public $showPreviewModal = false;
    public $previewFile = null;

    public function mount()
    {
        $this->currentFolderId = request('folder_id');
        if ($this->currentFolderId) {
            $this->currentFolder = Folder::where('id', $this->currentFolderId)
                ->where('user_id', auth()->id())
                ->first();
        }

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

    public function showMoveFileModal($id)
    {
        $this->moveFileId = $id;
    }

    public function showCopyFileModal($id)
    {
        $this->copyFileId = $id;
    }

    public function moveFileToFolder()
    {
        $this->validate([
            'targetFolderId' => 'nullable|exists:folders,id',
        ]);

        try {
            DB::transaction(function () {
                $file = File::where('id', $this->moveFileId)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($file) {
                    $file->folder_id = $this->targetFolderId;
                    $file->save();
                }
            });

            $this->reset(['moveFileId', 'targetFolderId']);
            $this->mount(); // Refresh data
            session()->flash('success', 'File berhasil dipindahkan ke folder.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal memindahkan file.');
        }
    }

    public function copyFileToFolder()
    {
        $this->validate([
            'targetFolderId' => 'nullable|exists:folders,id',
        ]);

        try {
            DB::transaction(function () {
                $originalFile = File::where('id', $this->copyFileId)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($originalFile) {
                    // Copy the physical file
                    $originalPath = $originalFile->path;
                    $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                    $newFileName = pathinfo($originalPath, PATHINFO_FILENAME) . '_copy_' . time() . '.' . $extension;
                    $newPath = 'uploads/' . $newFileName;

                    if (Storage::disk('public')->exists($originalPath)) {
                        Storage::disk('public')->copy($originalPath, $newPath);

                        // Create new file record
                        File::create([
                            'name' => $originalFile->name . ' (Copy)',
                            'original_name' => $originalFile->original_name,
                            'mime_type' => $originalFile->mime_type,
                            'size' => $originalFile->size,
                            'path' => $newPath,
                            'folder_id' => $this->targetFolderId,
                            'user_id' => auth()->id(),
                            'views' => 0,
                        ]);
                    }
                }
            });

            $this->reset(['copyFileId', 'targetFolderId']);
            $this->mount(); // Refresh data
            session()->flash('success', 'File berhasil disalin ke folder.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menyalin file.');
        }
    }

    public function showFilePreview($fileId)
    {
        $file = File::where('id', $fileId)
            ->where('user_id', auth()->id())
            ->first();

        if ($file) {
            $this->previewFile = $file;
            $this->showPreviewModal = true;

            // Increment view count
            $file->increment('views');
        }
    }

    #[On('closePreview')]
    public function closePreview()
    {
        $this->showPreviewModal = false;
        $this->previewFile = null;
    }

    public function getFileType($file)
    {
        if (!$file) return 'unknown';

        $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
        $mimeType = $file->mime_type;

        // Image files
        if (
            in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']) ||
            strpos($mimeType, 'image/') === 0
        ) {
            return 'image';
        }

        // Video files
        if (
            in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv']) ||
            strpos($mimeType, 'video/') === 0
        ) {
            return 'video';
        }

        // Audio files
        if (
            in_array($extension, ['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a']) ||
            strpos($mimeType, 'audio/') === 0
        ) {
            return 'audio';
        }

        // PDF files
        if ($extension === 'pdf' || $mimeType === 'application/pdf') {
            return 'pdf';
        }

        // Text files
        if (
            in_array($extension, ['txt', 'md', 'log']) ||
            strpos($mimeType, 'text/') === 0
        ) {
            return 'text';
        }

        // Office documents
        if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
            return 'office';
        }

        // Code files
        if (in_array($extension, ['php', 'js', 'css', 'html', 'json', 'xml', 'sql', 'py', 'java', 'cpp', 'c'])) {
            return 'code';
        }

        return 'unknown';
    }

    public function getFileContent($file)
    {
        try {
            if (!$file || !Storage::disk('public')->exists($file->path)) {
                return 'File not found';
            }

            $content = Storage::disk('public')->get($file->path);
            return $content;
        } catch (\Exception $e) {
            return 'Error reading file: ' . $e->getMessage();
        }
    }

    public function browseFolder($folderId = null)
    {
        $this->currentFolderId = $folderId;
        if ($folderId) {
            $this->currentFolder = Folder::where('id', $folderId)
                ->where('user_id', auth()->id())
                ->first();
        } else {
            $this->currentFolder = null;
        }
        $this->resetPage();
    }

    public function goToParentFolder()
    {
        if ($this->currentFolder && $this->currentFolder->parent_id) {
            $this->browseFolder($this->currentFolder->parent_id);
        } else {
            $this->browseFolder(null);
        }
    }

    public function showMoveModal($id)
    {
        $this->moveFolderId = $id;
    }

    public function moveFolder()
    {
        $this->validate([
            'targetFolderId' => 'nullable|exists:folders,id',
        ]);

        try {
            DB::transaction(function () {
                $folder = Folder::where('id', $this->moveFolderId)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($folder) {
                    // Prevent moving folder to itself or its children
                    if ($this->targetFolderId == $this->moveFolderId) {
                        throw new \Exception('Cannot move folder to itself');
                    }

                    // Check if target is a child of current folder (prevent loop)
                    if ($this->targetFolderId && $this->isChildOf($this->targetFolderId, $this->moveFolderId)) {
                        throw new \Exception('Cannot move folder to its own child');
                    }

                    $folder->parent_id = $this->targetFolderId;
                    $folder->save();
                }
            });
            $this->reset(['moveFolderId', 'targetFolderId']);
            session()->flash('success', 'Folder berhasil dipindahkan.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal memindahkan folder: ' . $e->getMessage());
        }
    }

    private function isChildOf($childId, $parentId)
    {
        $child = Folder::find($childId);
        while ($child && $child->parent_id) {
            if ($child->parent_id == $parentId) {
                return true;
            }
            $child = $child->parent;
        }
        return false;
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

        // Get folders based on current directory
        $folders = Folder::where('user_id', $userId)
            ->where('parent_id', $this->currentFolderId)
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->get();

        // Get files based on current directory
        $files = File::where('user_id', $userId)
            ->where('folder_id', $this->currentFolderId)
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

        // Get all folders for select options
        $allFolders = Folder::where('user_id', $userId)->orderBy('name')->get();

        // Build breadcrumb
        $breadcrumb = collect();
        $currentFolder = $this->currentFolder;
        while ($currentFolder) {
            $breadcrumb->prepend($currentFolder);
            $currentFolder = $currentFolder->parent;
        }

        return view('livewire.dashboard.index', [
            'items' => $paginated,
            'totalSize' => $totalSize,
            'totalItems' => $totalItems,
            'allFolders' => $allFolders,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}
