<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Pojk;
use App\Models\Pks;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function sk()
    {
        $policies = Policy::latest()->get();
        return view('user.sk', compact('policies'));
    }

    public function pojk()
    {
        $pojks = Pojk::latest()->get();
        return view('user.pojk', compact('pojks'));
    }

    public function pks()
    {
        $pks = Pks::latest()->get();
        return view('user.pks', compact('pks'));
    }

    public function video()
    {
        $videos = \App\Models\PolicyVideo::latest()->get();
        return view('user.video', compact('videos'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => 'nullable|string|min:6',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok dengan data kami.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
