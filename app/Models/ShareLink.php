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
        if (!$this->allowed_referer) return true;
        return parse_url($referer, PHP_URL_HOST) === parse_url($this->allowed_referer, PHP_URL_HOST);
    }
}
