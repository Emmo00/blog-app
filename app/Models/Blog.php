<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        "title",
        "description",
        "content",
        "thumbnail",
        "main_image",
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
