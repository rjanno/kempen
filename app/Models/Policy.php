<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = ['title', 'file_path', 'effective_date', 'status', 'category'];
}
