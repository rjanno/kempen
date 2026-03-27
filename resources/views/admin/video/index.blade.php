@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <h2>Manajemen Video / Sosialisasi</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahVideoModal">
        <i class="fas fa-plus me-1"></i> Tambah Video
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Judul Video</th>
                        <th>Preview URL</th>
                        <th>Tanggal Ditambahkan</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $index => $video)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td class="fw-medium">{{ $video->title }}</td>
                        <td>
                            <a href="{{ $video->video_url }}" target="_blank" class="text-primary text-decoration-none">
                                <i class="fab fa-youtube text-danger me-1"></i> Buka Tautan
                            </a>
                        </td>
                        <td>{{ $video->created_at->format('d M Y') }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editVideoModal{{ $video->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Video / Sosialisasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-video-slash mb-2 fs-2"></i><br>
                            Belum ada Data Video / Sosialisasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Video -->
<div class="modal fade" id="tambahVideoModal" tabindex="-1" aria-labelledby="tambahVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.video.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahVideoModalLabel"><i class="fas fa-video me-2"></i>Tambah Video / Sosialisasi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Video / Sosialisasi</label>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="Contoh: Sosialisasi Juknis 2026">
                    </div>
                    <div class="mb-3">
                        <label for="video_url" class="form-label fw-bold">URL Video</label>
                        <input type="url" class="form-control" id="video_url" name="video_url" required placeholder="https://www.youtube.com/watch?v=...">
                        <div class="form-text">Masukkan link YouTube atau platform video lainnya.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Video</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($videos as $video)
<!-- Modal Edit Video -->
<div class="modal fade" id="editVideoModal{{ $video->id }}" tabindex="-1" aria-labelledby="editVideoModalLabel{{ $video->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.video.update', $video->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editVideoModalLabel{{ $video->id }}"><i class="fas fa-edit me-2"></i>Edit Video / Sosialisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title{{ $video->id }}" class="form-label fw-bold">Judul Video / Sosialisasi</label>
                        <input type="text" class="form-control" id="title{{ $video->id }}" name="title" value="{{ $video->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="video_url{{ $video->id }}" class="form-label fw-bold">URL Video</label>
                        <input type="url" class="form-control" id="video_url{{ $video->id }}" name="video_url" value="{{ $video->video_url }}" required>
                        <div class="form-text">Pastikan link valid (cth: YouTube).</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update Video</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
