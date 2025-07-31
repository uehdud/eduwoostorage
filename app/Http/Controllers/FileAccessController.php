<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FileAccessController extends Controller
{
    public function serve(Request $request, $fileId)
    {
        // Get file
        $file = File::findOrFail($fileId);

        // Check if user owns the file or if it's accessed from allowed domains
        $referer = $request->headers->get('referer');
        $allowedHosts = [
            'eduwoo.id',
            'www.eduwoo.id',
            'srv888802.hstgr.cloud',
            '127.0.0.1',
            'localhost',
        ];
        $refererHost = $referer ? parse_url($referer, PHP_URL_HOST) : null;

        // Check if user is authenticated and owns the file, or if referer is allowed
        $hasAccess = false;
        if (Auth::check() && Auth::id() === $file->user_id) {
            $hasAccess = true;
        } elseif (in_array($refererHost, $allowedHosts)) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            abort(403, 'Access denied');
        }

        $path = storage_path('app/public/' . $file->path);

        if (!file_exists($path)) {
            abort(404);
        }

        $mime = $file->mime_type ?? 'application/octet-stream';
        $size = filesize($path);
        $start = 0;
        $end = $size - 1;

        // Determine allowed origin based on referer
        $allowedOrigin = '*';
        $frameOptions = 'SAMEORIGIN';

        if ($refererHost) {
            if (in_array($refererHost, ['eduwoo.id', 'www.eduwoo.id'])) {
                $allowedOrigin = 'https://' . $refererHost;
                $frameOptions = 'ALLOWALL';
            } elseif ($refererHost === 'srv888802.hstgr.cloud') {
                $allowedOrigin = 'https://srv888802.hstgr.cloud';
                $frameOptions = 'ALLOWALL';
            } elseif (in_array($refererHost, ['127.0.0.1', 'localhost'])) {
                $allowedOrigin = '*';
                $frameOptions = 'ALLOWALL';
            }
        }

        $headers = [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . ($file->original_name ?? basename($path)) . '"',
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=3600',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => $frameOptions,
            'Access-Control-Allow-Origin' => $allowedOrigin,
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Range, Origin, Referer, Accept, Authorization, Content-Type',
            'Access-Control-Expose-Headers' => 'Content-Range, Accept-Ranges, Content-Length, Content-Type',
            'Access-Control-Allow-Credentials' => 'true',
        ];

        // Handle OPTIONS preflight request
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 200, $headers);
        }

        // Log access for debugging
        Log::info('File access request', [
            'file_id' => $fileId,
            'referer' => $referer,
            'referer_host' => $refererHost,
            'user_id' => Auth::id(),
            'file_owner' => $file->user_id,
            'has_access' => $hasAccess
        ]);

        // Handle HTTP Range header for video seeking
        if ($request->headers->has('Range')) {
            $range = $request->header('Range');
            if (preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
                $start = intval($matches[1]);
                if ($matches[2] !== '') {
                    $end = intval($matches[2]);
                }
            }
            if ($end > $size - 1) $end = $size - 1;
            $length = $end - $start + 1;
            $fh = fopen($path, 'rb');
            fseek($fh, $start);

            $headers['Content-Range'] = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;

            return response()->stream(function () use ($fh, $length) {
                $buffer = 8192;
                $bytesSent = 0;
                while (!feof($fh) && $bytesSent < $length) {
                    $read = min($buffer, $length - $bytesSent);
                    echo fread($fh, $read);
                    $bytesSent += $read;
                    @ob_flush();
                    flush();
                }
                fclose($fh);
            }, 206, $headers);
        } else {
            // No Range header, stream the whole file
            $headers['Content-Length'] = $size;
            return response()->file($path, $headers);
        }
    }

    public function serveByPath(Request $request, $filename)
    {
        // Cari file berdasarkan path
        $file = File::where('path', 'uploads/' . $filename)->first();
        
        if (!$file) {
            abort(404, 'File not found');
        }

        // Check if user owns the file or if it's accessed from allowed domains
        $referer = $request->headers->get('referer');
        $allowedHosts = [
            'eduwoo.id',
            'www.eduwoo.id',
            'srv888802.hstgr.cloud',
            '127.0.0.1',
            'localhost',
        ];
        $refererHost = $referer ? parse_url($referer, PHP_URL_HOST) : null;

        // Check if user is authenticated and owns the file, or if referer is allowed
        $hasAccess = false;
        if (Auth::check() && Auth::id() === $file->user_id) {
            $hasAccess = true;
        } elseif (in_array($refererHost, $allowedHosts)) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            abort(403, 'Access denied');
        }

        $path = storage_path('app/public/' . $file->path);

        if (!file_exists($path)) {
            abort(404);
        }

        $mime = $file->mime_type ?? 'application/octet-stream';
        $size = filesize($path);
        $start = 0;
        $end = $size - 1;

        // Determine allowed origin based on referer
        $allowedOrigin = '*';
        $frameOptions = 'SAMEORIGIN';
        
        if ($refererHost) {
            if (in_array($refererHost, ['eduwoo.id', 'www.eduwoo.id'])) {
                $allowedOrigin = 'https://' . $refererHost;
                $frameOptions = 'ALLOWALL';
            } elseif ($refererHost === 'srv888802.hstgr.cloud') {
                $allowedOrigin = 'https://srv888802.hstgr.cloud';
                $frameOptions = 'ALLOWALL';
            } elseif (in_array($refererHost, ['127.0.0.1', 'localhost'])) {
                $allowedOrigin = '*';
                $frameOptions = 'ALLOWALL';
            }
        }

        $headers = [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . ($file->original_name ?? basename($path)) . '"',
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=3600',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => $frameOptions,
            'Access-Control-Allow-Origin' => $allowedOrigin,
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Range, Origin, Referer, Accept, Authorization, Content-Type',
            'Access-Control-Expose-Headers' => 'Content-Range, Accept-Ranges, Content-Length, Content-Type',
            'Access-Control-Allow-Credentials' => 'true',
        ];

        // Handle OPTIONS preflight request
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 200, $headers);
        }

        // Log access for debugging
        Log::info('File storage path access', [
            'filename' => $filename,
            'file_id' => $file->id,
            'referer' => $referer,
            'referer_host' => $refererHost,
            'user_id' => Auth::id(),
            'file_owner' => $file->user_id,
            'has_access' => $hasAccess
        ]);

        // Handle HTTP Range header for video seeking
        if ($request->headers->has('Range')) {
            $range = $request->header('Range');
            if (preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
                $start = intval($matches[1]);
                if ($matches[2] !== '') {
                    $end = intval($matches[2]);
                }
            }
            if ($end > $size - 1) $end = $size - 1;
            $length = $end - $start + 1;
            $fh = fopen($path, 'rb');
            fseek($fh, $start);

            $headers['Content-Range'] = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;

            return response()->stream(function () use ($fh, $length) {
                $buffer = 8192;
                $bytesSent = 0;
                while (!feof($fh) && $bytesSent < $length) {
                    $read = min($buffer, $length - $bytesSent);
                    echo fread($fh, $read);
                    $bytesSent += $read;
                    @ob_flush();
                    flush();
                }
                fclose($fh);
            }, 206, $headers);
        } else {
            // No Range header, stream the whole file
            $headers['Content-Length'] = $size;
            return response()->file($path, $headers);
        }
    }