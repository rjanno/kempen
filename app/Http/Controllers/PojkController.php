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
            $filename = \Illuminate\Support\Str::slug($pojk->title) . '.pdf';
            return response()->download(storage_path('app/public/' . $pojk->file_path), $filename);
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    public function viewFile($id)
    {
        $pojk = Pojk::findOrFail($id);
        
        if ($pojk->file_path && Storage::disk('public')->exists($pojk->file_path)) {
            $pojk->increment('views_count');
            $filename = \Illuminate\Support\Str::slug($pojk->title) . '.pdf';
            return response()->file(storage_path('app/public/' . $pojk->file_path), [
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}
