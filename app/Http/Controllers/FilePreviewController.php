<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilePreviewController extends Controller
{
    public function textPreview($fileId)
    {
        try {
            $file = File::where('id', $fileId)
                ->where('user_id', auth()->id())
                ->first();

            if (!$file) {
                return response('File tidak ditemukan.', 404);
            }

            $filePath = storage_path('app/public/' . $file->path);

            if (!file_exists($filePath)) {
                return response('File tidak ditemukan di storage.', 404);
            }

            // Check file size - limit to 512KB for text preview
            if ($file->size > 524288) {
                return response('File terlalu besar untuk preview text (maksimal 512KB).\nSilakan download file untuk melihat konten lengkap.', 200);
            }

            // Check if it's actually a text file
            if (!$this->isTextFile($file->mime_type)) {
                return response('File bukan tipe text.', 400);
            }

            // Read file with size limit and timeout protection
            $handle = fopen($filePath, 'r');
            if (!$handle) {
                return response('Tidak dapat membaca file.', 500);
            }

            // Read maximum 100KB for preview
            $content = fread($handle, min(102400, $file->size));
            fclose($handle);

            // Ensure UTF-8 encoding
            if (!mb_check_encoding($content, 'UTF-8')) {
                $content = mb_convert_encoding($content, 'UTF-8', 'auto');
            }

            // Add truncation notice if file is larger than what we read
            if ($file->size > 102400) {
                $content .= "\n\n... (Content truncated. Download file to see complete content.)";
            }

            return response($content, 200, [
                'Content-Type' => 'text/plain; charset=utf-8'
            ]);
        } catch (\Exception $e) {
            return response('Error: ' . $e->getMessage(), 500);
        }
    }

    private function isTextFile($mimeType)
    {
        $textMimeTypes = [
            'text/plain',
            'text/html',
            'text/css',
            'text/javascript',
            'text/xml',
            'text/csv',
            'application/json',
            'application/xml',
            'application/javascript',
            'application/x-php',
            'application/x-python',
            'application/x-ruby',
            'application/x-java',
            'application/x-c',
            'application/x-cpp',
            'application/x-csharp',
            'application/x-sql',
            'application/x-yaml',
            'application/x-dockerfile',
            'application/x-sh',
            'application/x-bash',
        ];

        return in_array($mimeType, $textMimeTypes) ||
            str_starts_with($mimeType, 'text/') ||
            str_ends_with($mimeType, '+json') ||
            str_ends_with($mimeType, '+xml');
    }
}
