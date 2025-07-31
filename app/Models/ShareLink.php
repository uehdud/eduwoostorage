<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareLink extends Model
{
    protected $fillable = [
        'token',
        'type',
        'target_id',
        'allowed_referer',
        'expires_at'
    ];

    public function isValidReferer($referer)
    {
        $allowedHosts = ['eduwoo.id', 'www.eduwoo.id'];
        $host = $referer ? parse_url($referer, PHP_URL_HOST) : null;
        return $host && in_array($host, $allowedHosts);
    }
}
