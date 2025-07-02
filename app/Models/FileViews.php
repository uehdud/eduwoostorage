<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileViews extends Model
{
    protected $table = 'file_views';

    protected $fillable = [
        'file_id',
        'user_id',
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
