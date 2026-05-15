<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'filename',
        'original_name',
        'mime_type',
        'path',
        'size',
        'type',
        'alt_text',
        'caption',
        'description',
        'uploaded_by',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->path);
    }

    public function getHumanSizeAttribute()
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        }
        return $bytes . ' B';
    }

    public function isImage()
    {
        return $this->type === 'image';
    }

    public function isDocument()
    {
        return $this->type === 'document';
    }

    public function isVideo()
    {
        return $this->type === 'video';
    }

    public function getExtensionAttribute()
    {
        return strtoupper(pathinfo($this->original_name, PATHINFO_EXTENSION));
    }
}
