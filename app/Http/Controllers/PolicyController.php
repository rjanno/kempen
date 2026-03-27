<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;
use Illuminate\Support\Facades\Storage;

class PolicyController extends Controller
{
    public function download($id)
    {
        $policy = Policy::findOrFail($id);
        
        if ($policy->file_path && Storage::disk('public')->exists($policy->file_path)) {
            $policy->increment('views_count');
            return response()->download(storage_path('app/public/' . $policy->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    public function viewFile($id)
    {
        $policy = Policy::findOrFail($id);
        
        if ($policy->file_path && Storage::disk('public')->exists($policy->file_path)) {
            $policy->increment('views_count');
            return response()->file(storage_path('app/public/' . $policy->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}
