@extends('layouts.app')

@push('styles')
<style>
    .sk-card {
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .sk-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4 border-bottom pb-3">
    <h2 class="fw-bold m-0 text-dark">Video Sosialisasi</h2>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse($videos as $video)
    <div class="col">
        <div class="card border-0 shadow-sm h-100 sk-card">
            <div class="card-body text-center py-5">
                <i class="fas fa-play-circle text-danger mb-3" style="font-size: 4rem;"></i>
                <h5 class="card-title fw-bold text-dark">{{ $video->title }}</h5>
                <p class="text-muted small mb-0"><i class="far fa-clock me-1"></i> {{ $video->created_at->diffForHumans() }}</p>
            </div>
            <div class="card-footer bg-white border-0 text-center pb-4">
                <a href="{{ $video->video_url }}" target="_blank" class="btn btn-primary px-4 rounded-pill">
                    <i class="fas fa-external-link-alt me-1"></i> Tonton Video
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 w-100">
        <div class="text-center py-5 text-muted bg-white rounded-3 shadow-sm border-0">
            <i class="fas fa-video-slash mb-3 fs-1 text-secondary"></i><br>
            <span class="fs-5">Belum ada Video Sosialisasi yang tersedia.</span>
        </div>
    </div>
    @endforelse
</div>
@endsection
