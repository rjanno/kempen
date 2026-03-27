<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pojk;
use Illuminate\Support\Facades\Storage;

class PojkController extends Controller
{
    public function download($id)
    {
        $pojk = Pojk::findOrFail($id);
        
        if ($pojk->file_path && Storage::disk('public')->exists($pojk->file_path)) {
            $pojk->increment('views_count');
            return response()->download(storage_path('app/public/' . $pojk->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    public function viewFile($id)
    {
        $pojk = Pojk::findOrFail($id);
        
        if ($pojk->file_path && Storage::disk('public')->exists($pojk->file_path)) {
            $pojk->increment('views_count');
            return response()->file(storage_path('app/public/' . $pojk->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}
