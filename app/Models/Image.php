<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'blog_id'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
