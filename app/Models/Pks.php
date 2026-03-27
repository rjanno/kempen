<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pks extends Model
{
    protected $fillable = [
        'title',
        'effective_date',
        'status',
        'category',
        'file_path',
        'views_count'
    ];
}
