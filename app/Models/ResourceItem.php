<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceItem extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'title',
        'description',
        'category',
        'file_url',
        'author_or_source',
    ];
}

