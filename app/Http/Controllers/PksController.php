<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pks;
use Illuminate\Support\Facades\Storage;

class PksController extends Controller
{
    public function download($id)
    {
        $pks = Pks::findOrFail($id);
        
        if ($pks->file_path && Storage::disk('public')->exists($pks->file_path)) {
            $pks->increment('views_count');
            $filename = \Illuminate\Support\Str::slug($pks->title) . '.pdf';
            return response()->download(storage_path('app/public/' . $pks->file_path), $filename);
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    public function viewFile($id)
    {
        $pks = Pks::findOrFail($id);
        
        if ($pks->file_path && Storage::disk('public')->exists($pks->file_path)) {
            $pks->increment('views_count');
            $filename = \Illuminate\Support\Str::slug($pks->title) . '.pdf';
            return response()->file(storage_path('app/public/' . $pks->file_path), [
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}
