<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'translated_title',
        'translated_description',
        'image_url',
        'photo_div_id',
    ];
    
}
