<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShareLink;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class ShareLinkController extends Controller
{
    // Generate a share link for file or folder
    public function generate(Request $request)
    {
        Log::info('ShareLink generate request', [
            'type' => $request->type,
            'id' => $request->id,
            'headers' => $request->headers->all()
        ]);

        $request->validate([
            'type' => 'required|in:file,folder',
            'id' => 'required|integer',
        ]);

        // Verify that the target exists
        if ($request->type === 'file') {
            $target = File::find($request->id);
        } else {
            $target = Folder::find($request->id);
        }

        if (!$target) {
            Log::error('Target not found', ['type' => $request->type, 'id' => $request->id]);
            return response()->json(['error' => 'Target not found'], 404);
        }

        // Get referer to set appropriate allowed referer
        $referer = $request->headers->get('referer');
        $refererHost = $referer ? parse_url($referer, PHP_URL_HOST) : null;

        $allowedReferer = 'http://127.0.0.1:8000/';
        if ($refererHost === 'srv888802.hstgr.cloud') {
            $allowedReferer = 'https://srv888802.hstgr.cloud/';
        } elseif (in_array($refererHost, ['eduwoo.id', 'www.eduwoo.id'])) {
            $allowedReferer = 'https://' . $refererHost . '/';
        }

        $token = Str::random(32);

        $shareLink = ShareLink::create([
            'token' => $token,
            'type' => $request->type,
            'target_id' => $request->id,
            'allowed_referer' => $allowedReferer,
            'expires_at' => now()->addDays(7),
        ]);

        $url = URL::to('/share/' . $token);

        Log::info('ShareLink generated successfully', [
            'token' => $token,
            'type' => $request->type,
            'target_id' => $request->id,
            'url' => $url
        ]);

        return response()->json(['url' => $url]);
    }

    // Access the shared file/folder
    public function access(Request $request, $token)
    {
        $shareLink = ShareLink::where('token', $token)->firstOrFail();

        // Handle OPTIONS preflight request
        if ($request->getMethod() === 'OPTIONS') {
            $referer = $request->headers->get('referer');
            $allowedHosts = [
                'eduwoo.id',
                'www.eduwoo.id',
                'srv888802.hstgr.cloud',
                '127.0.0.1',
                'localhost',
            ];
            $refererHost = $referer ? parse_url($referer, PHP_URL_HOST) : null;

            $allowedOrigin = '*';
            if ($refererHost && in_array($refererHost, $allowedHosts)) {
                if (in_array($refererHost, ['eduwoo.id', 'www.eduwoo.id'])) {
                    $allowedOrigin = 'https://' . $refererHost;
                } elseif ($refererHost === 'srv888802.hstgr.cloud') {
                    $allowedOrigin = 'https://srv888802.hstgr.cloud';
                }
            }

            return response('', 200, [
                'Access-Control-Allow-Origin' => $allowedOrigin,
                'Access-Control-Allow-Methods' => 'GET, OPTIONS',
                'Access-Control-Allow-Headers' => 'Range, Origin, Referer, Accept, Authorization, Content-Type',
                'Access-Control-Max-Age' => '86400',
                'Access-Control-Allow-Credentials' => 'true',
            ]);
        }

        // Only allow referer from specified domains
        $referer = $request->headers->get('referer');
        $allowedHosts = [
            'eduwoo.id',
            'www.eduwoo.id',
            'srv888802.hstgr.cloud',
            '127.0.0.1',
            'localhost',
        ];
        $refererHost = $referer ? parse_url($referer, PHP_URL_HOST) : null;
        if (!$refererHost || !in_array($refererHost, $allowedHosts)) {
            abort(403, 'Access denied: invalid referer');
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

            // Determine allowed origin based on referer
            $allowedOrigin = '*';
            $frameOptions = 'DENY';

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
                'Cache-Control' => 'no-store, must-revalidate',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => $frameOptions,
                'X-Robots-Tag' => 'noindex, nofollow',
                'Access-Control-Allow-Origin' => $allowedOrigin,
                'Access-Control-Allow-Methods' => 'GET, OPTIONS',
                'Access-Control-Allow-Headers' => 'Range, Origin, Referer, Accept, Authorization, Content-Type',
                'Access-Control-Expose-Headers' => 'Content-Range, Accept-Ranges, Content-Length, Content-Type',
                'Access-Control-Allow-Credentials' => 'true',
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
