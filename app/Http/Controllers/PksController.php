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
            return response()->download(storage_path('app/public/' . $pks->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    public function viewFile($id)
    {
        $pks = Pks::findOrFail($id);
        
        if ($pks->file_path && Storage::disk('public')->exists($pks->file_path)) {
            $pks->increment('views_count');
            return response()->file(storage_path('app/public/' . $pks->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}
