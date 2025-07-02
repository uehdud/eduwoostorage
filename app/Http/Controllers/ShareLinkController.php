<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShareLink;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ShareLinkController extends Controller
{
    // Generate a share link for file or folder
    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:file,folder',
            'id' => 'required|integer',
        ]);
        $allowedReferer = 'http://127.0.0.1:8000/';
        $token = Str::random(32);

        $shareLink = ShareLink::create([
            'token' => $token,
            'type' => $request->type,
            'target_id' => $request->id,
            'allowed_referer' => $allowedReferer,
            'expires_at' => now()->addDays(7),
        ]);

        $url = URL::to('/share/' . $token);

        return response()->json(['url' => $url]);
    }

    // Access the shared file/folder
    public function access(Request $request, $token)
    {
        $shareLink = ShareLink::where('token', $token)->firstOrFail();

        // Validasi referer: hanya izinkan dari domain tertentu
        $referer = $request->headers->get('referer');
        $allowedHosts = [
            '127.0.0.1',
            'localhost',
            'www.eduwoo.id',
            'eduwoo.id',
        ];
        $refererHost = $referer ? parse_url($referer, PHP_URL_HOST) : null;

        // Perbaikan: izinkan juga jika referer kosong (akses langsung dari browser/video tag di local)
        if (app()->environment('local')) {
            // Jika di local, izinkan referer kosong atau host local
            if ($refererHost && !in_array($refererHost, $allowedHosts)) {
                abort(403, 'Access denied: invalid referer');
            }
        } else {
            // Production: referer wajib dan harus sesuai
            if (!$refererHost || !in_array($refererHost, $allowedHosts)) {
                abort(403, 'Access denied: invalid referer');
            }
        }

        // Optionally check expiry
        if ($shareLink->expires_at && now()->greaterThan($shareLink->expires_at)) {
            abort(410, 'Link expired');
        }

        if ($shareLink->type === 'file') {
            $file = File::findOrFail($shareLink->target_id);
            $path = storage_path('app/public/' . $file->path);

            if (!file_exists($path)) {
                abort(404);
            }

            $mime = $file->mime_type ?? 'video/mp4';
            $size = filesize($path);
            $start = 0;
            $end = $size - 1;

            $headers = [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="' . ($file->original_name ?? basename($path)) . '"',
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'no-store, must-revalidate',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'DENY',
                'X-Robots-Tag' => 'noindex, nofollow',
                // Ganti origin sesuai domain produksi Anda
                // 'Access-Control-Allow-Origin' => 'https://www.eduwoo.id',
                'Access-Control-Allow-Methods' => 'GET, OPTIONS',
                'Access-Control-Allow-Headers' => 'Range, Origin, Referer, Accept, Authorization, Content-Type',
                'Access-Control-Expose-Headers' => 'Content-Range, Accept-Ranges, Content-Length, Content-Type',
            ];

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
        } else {
            // For folder, you may return a list or zip, implement as needed
            return response('Folder sharing not implemented', 501);
        }
    }
}
