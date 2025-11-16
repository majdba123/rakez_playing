<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'projects_count'
    ];

    protected $casts = [
        'projects_count' => 'integer'
    ];
}
