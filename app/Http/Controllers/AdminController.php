<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Pojk;
use App\Models\Pks;
use App\Models\PolicyVideo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSKNotification;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalSK = Policy::count();
        $totalVideo = PolicyVideo::count();
        $totalUsers = User::count();

        // Data for Chart (Top 5 Viewed SK)
        $topPolicies = Policy::orderBy('views_count', 'desc')->take(5)->get(['title', 'views_count']);

        // Data for User Login Frequency Chart
        // Allow filtering by 'days' parameter, default to 7 days
        $days = $request->input('days', 7);
        $startDate = now()->subDays($days)->startOfDay();

        $loginStats = \App\Models\LoginHistory::with('user')
            ->where('created_at', '>=', $startDate)
            ->select('user_id', \DB::raw('count(*) as total_logins'))
            ->groupBy('user_id')
            ->orderBy('total_logins', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('totalSK', 'totalVideo', 'totalUsers', 'topPolicies', 'loginStats', 'days'));
    }

    public function sk()
    {
        $policies = Policy::orderByDesc('effective_date')->get();
        return view('admin.sk.index', compact('policies'));
    }

    public function storeSk(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:10240',
            'effective_date' => 'nullable|date',
            'status' => 'required|in:berlaku,tidak_berlaku',
            'category' => 'required|in:sk,kpo,spo,mi,se'
        ]);

        $path = $request->file('file')->store('policies', 'public');

        $policy = Policy::create([
            'title' => $request->title,
            'file_path' => $path,
            'effective_date' => $request->effective_date,
            'status' => $request->status,
            'category' => $request->category
        ]);

        // Fetch users to notify (can be all, or just role='user')
        // $users = User::where('role', 'user')->get();
        // if ($users->isNotEmpty()) {
        //     // Because we're using Mailtrap in local, we can just map the emails
        //     // If in production, you might want to queue this or send via BCC.
        //     Mail::to($users)->send(new NewSKNotification($policy));
        // }

        return back()->with('success', 'SK berhasil diunggah.');
    }

    public function updateSk(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf|max:10240',
            'effective_date' => 'nullable|date',
            'status' => 'required|in:berlaku,tidak_berlaku',
            'category' => 'required|in:sk,kpo,spo,mi,se'
        ]);

        $data = [
            'title' => $request->title,
            'effective_date' => $request->effective_date,
            'status' => $request->status,
            'category' => $request->category
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($policy->file_path && Storage::disk('public')->exists($policy->file_path)) {
                Storage::disk('public')->delete($policy->file_path);
            }
            // Store new file
            $data['file_path'] = $request->file('file')->store('policies', 'public');
        }

        $policy->update($data);

        return back()->with('success', 'SK berhasil diperbarui.');
    }

    public function destroySk($id)
    {
        $policy = Policy::findOrFail($id);
        if ($policy->file_path && Storage::disk('public')->exists($policy->file_path)) {
            Storage::disk('public')->delete($policy->file_path);
        }
        $policy->delete();

        return back()->with('success', 'SK berhasil dihapus.');
    }

    public function pojk()
    {
        $pojks = Pojk::orderByDesc('effective_date')->get();
        return view('admin.pojk.index', compact('pojks'));
    }

    public function storePojk(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:10240',
            'effective_date' => 'nullable|date',
            'status' => 'required|in:berlaku,tidak_berlaku',
            'category' => 'required|in:pojk,padk'
        ]);

        $path = $request->file('file')->store('pojks', 'public');

        Pojk::create([
            'title' => $request->title,
            'file_path' => $path,
            'effective_date' => $request->effective_date,
            'status' => $request->status,
            'category' => $request->category
        ]);

        return back()->with('success', 'POJK berhasil diunggah.');
    }

    public function updatePojk(Request $request, $id)
    {
        $pojk = Pojk::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf|max:10240',
            'effective_date' => 'nullable|date',
            'status' => 'required|in:berlaku,tidak_berlaku',
            'category' => 'required|in:pojk,padk'
        ]);

        $data = [
            'title' => $request->title,
            'effective_date' => $request->effective_date,
            'status' => $request->status,
            'category' => $request->category
        ];

        if ($request->hasFile('file')) {
            if ($pojk->file_path && Storage::disk('public')->exists($pojk->file_path)) {
                Storage::disk('public')->delete($pojk->file_path);
            }
            $data['file_path'] = $request->file('file')->store('pojks', 'public');
        }

        $pojk->update($data);

        return back()->with('success', 'POJK berhasil diperbarui.');
    }

    public function destroyPojk($id)
    {
        $pojk = Pojk::findOrFail($id);
        if ($pojk->file_path && Storage::disk('public')->exists($pojk->file_path)) {
            Storage::disk('public')->delete($pojk->file_path);
        }
        $pojk->delete();

        return back()->with('success', 'POJK berhasil dihapus.');
    }

    public function pks()
    {
        $pks = Pks::orderByDesc('effective_date')->get();
        return view('admin.pks.index', compact('pks'));
    }

    public function storePks(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:10240',
            'effective_date' => 'nullable|date',
            'status' => 'required|in:berlaku,tidak_berlaku',
            'category' => 'required|in:pks'
        ]);

        $path = $request->file('file')->store('pks', 'public');

        Pks::create([
            'title' => $request->title,
            'file_path' => $path,
            'effective_date' => $request->effective_date,
            'status' => $request->status,
            'category' => $request->category
        ]);

        return back()->with('success', 'PKS berhasil diunggah.');
    }

    public function updatePks(Request $request, $id)
    {
        $pks = Pks::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf|max:102400',
            'effective_date' => 'nullable|date',
            'status' => 'required|in:berlaku,tidak_berlaku',
            'category' => 'required|in:pks'
        ]);

        $data = [
            'title' => $request->title,
            'effective_date' => $request->effective_date,
            'status' => $request->status,
            'category' => $request->category
        ];

        if ($request->hasFile('file')) {
            if ($pks->file_path && Storage::disk('public')->exists($pks->file_path)) {
                Storage::disk('public')->delete($pks->file_path);
            }
            $data['file_path'] = $request->file('file')->store('pks', 'public');
        }

        $pks->update($data);

        return back()->with('success', 'PKS berhasil diperbarui.');
    }

    public function destroyPks($id)
    {
        $pks = Pks::findOrFail($id);
        if ($pks->file_path && Storage::disk('public')->exists($pks->file_path)) {
            Storage::disk('public')->delete($pks->file_path);
        }
        $pks->delete();

        return back()->with('success', 'PKS berhasil dihapus.');
    }
    public function video()
    {
        $videos = PolicyVideo::latest()->get();
        return view('admin.video.index', compact('videos'));
    }

    public function storeVideo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url|max:255'
        ]);

        PolicyVideo::create([
            'title' => $request->title,
            'video_url' => $request->video_url
        ]);

        return back()->with('success', 'Video / Sosialisasi berhasil ditambahkan.');
    }

    public function updateVideo(Request $request, $id)
    {
        $video = PolicyVideo::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url|max:255'
        ]);

        $video->update([
            'title' => $request->title,
            'video_url' => $request->video_url
        ]);

        return back()->with('success', 'Video / Sosialisasi berhasil diperbarui.');
    }

    public function destroyVideo($id)
    {
        $video = PolicyVideo::findOrFail($id);
        $video->delete();

        return back()->with('success', 'Video / Sosialisasi berhasil dihapus.');
    }
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->email === 'anno@pb.com' && auth()->user()->email !== 'anno@pb.com') {
            return back()->with('error', 'Hanya Super Admin yang dapat mengubah data akunnya sendiri.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,user'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];

        // Jika admin mengisi password baru, ubah passwordnya
        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data Pengguna berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting the currently authenticated admin
        if (\Illuminate\Support\Facades\Auth::id() == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->email === 'anno@pb.com') {
            return back()->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
