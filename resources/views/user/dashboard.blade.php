@extends('layouts.app')

@push('styles')
<style>
    .nav-pills-custom .nav-link {
        color: #6c757d;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .nav-pills-custom .nav-link:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }
    .nav-pills-custom .nav-link.active {
        color: white;
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        box-shadow: 0 5px 15px rgba(124, 58, 237, 0.3);
    }
    .modern-table-card {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }
    .modern-table thead th {
        background-color: #f8f9fc;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        color: #5c636a;
        padding: 1.2rem 1rem;
        border-bottom: 2px solid #eaedf1;
    }
    .modern-table tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        color: #4a5568;
        border-bottom: 1px solid #f1f3f5;
    }
    .modern-table tbody tr {
        transition: all 0.2s;
    }
    .modern-table tbody tr:hover {
        background-color: #fcfcff;
        transform: scale(1.001);
    }
    .search-pill {
        border-radius: 50px;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    .search-icon-wrapper {
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
        padding-left: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="mb-5">
    <h2 class="fw-bold text-gray-800">Direktori Regulasi Internal</h2>
    <p class="text-muted">Akses seluruh dokumen administratif dan panduan sosialisasi.</p>
</div>

<ul class="nav nav-pills nav-pills-custom gap-3 mb-5" id="skTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fs-6" id="sk-tab" data-bs-toggle="tab" data-bs-target="#sk-tab-pane" type="button" role="tab">
            <i class="fas fa-file-pdf me-2"></i> Dokumen Teks (PDF)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fs-6" id="video-tab" data-bs-toggle="tab" data-bs-target="#video-tab-pane" type="button" role="tab">
            <i class="fas fa-play-circle me-2"></i> Video Sosialisasi
        </button>
    </li>
</ul>

<div class="tab-content" id="skTabsContent">
    <!-- TAB DOKUMEN SK -->
    <div class="tab-pane fade show active" id="sk-tab-pane" role="tabpanel" tabindex="0">
        <div class="row mb-4 g-2">
            <div class="col-md-4">
                <div class="input-group shadow-sm" style="border-radius: 8px;">
                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0 shadow-none" placeholder="Cari judul SK...">
                </div>
            </div>
            <div class="col-md-2">
                <select id="categoryFilter" class="form-select shadow-sm" style="border-radius: 8px;">
                    <option value="all">Semua Kategori</option>
                    <option value="sk">SK</option>
                    <option value="kpo">KPO</option>
                    <option value="spo">SPO</option>
                    <option value="mi">MI</option>
                    <option value="se">SE</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select shadow-sm" style="border-radius: 8px;">
                    <option value="all">Semua Status</option>
                    <option value="berlaku">Berlaku</option>
                    <option value="tidak_berlaku">Tidak Berlaku</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="input-group shadow-sm" style="border-radius: 8px;">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-sort-amount-down"></i></span>
                    <select id="sortSelect" class="form-select border-start-0 shadow-none">
                        <option value="newest">Ditambahkan Terbaru</option>
                        <option value="oldest">Ditambahkan Terlama</option>
                        <option value="a-z">Alfabetik (A-Z)</option>
                        <option value="z-a">Alfabetik (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card modern-table-card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table modern-table mb-0" id="skTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Judul SK</th>
                                <th>Tanggal Upload</th>
                                <th>Tgl Berlaku</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="skTableBody">
                            @forelse($policies as $index => $sk)
                            <tr class="sk-row" data-title="{{ strtolower($sk->title) }}" data-date="{{ $sk->created_at->timestamp }}" data-category="{{ $sk->category }}" data-status="{{ $sk->status }}">
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">
                                    {{ $sk->title }}
                                </td>
                                <td>{{ $sk->created_at->format('d M Y') }}</td>
                                <td>{{ $sk->effective_date ? \Carbon\Carbon::parse($sk->effective_date)->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($sk->category == 'sk') <span class="badge bg-primary rounded-pill">SK</span>
                                    @elseif($sk->category == 'kpo') <span class="badge bg-info text-dark rounded-pill">KPO</span>
                                    @elseif($sk->category == 'spo') <span class="badge bg-success rounded-pill">SPO</span>
                                    @elseif($sk->category == 'mi') <span class="badge bg-warning text-dark rounded-pill">MI</span>
                                    @elseif($sk->category == 'se') <span class="badge bg-secondary rounded-pill">SE</span>
                                    @else <span class="badge bg-light text-dark rounded-pill">{{ strtoupper($sk->category) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sk->status == 'berlaku') <span class="badge bg-success rounded-pill px-3">Berlaku</span>
                                    @else <span class="badge bg-danger rounded-pill px-3">Tidak Berlaku</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    @if($sk->file_path)
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('sk.view', $sk->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-bold" title="Lihat File">
                                            <i class="fas fa-eye me-1"></i> Lihat
                                        </a>
                                        <a href="{{ route('sk.download', $sk->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" title="Unduh File">
                                            <i class="fas fa-cloud-download-alt me-1"></i> Unduh
                                        </a>
                                    </div>
                                    @else
                                    <span class="badge bg-light text-muted border px-3 py-2 rounded-pill"><i class="fas fa-ban me-1"></i> Tidak Ada File</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open mb-2 fs-2"></i><br>
                                    Belum ada Surat Keputusan yang tersedia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB VIDEO SK -->
    <div class="tab-pane fade" id="video-tab-pane" role="tabpanel" tabindex="0">
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
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-video-slash mb-3 fs-1"></i><br>
                    Belum ada Video SK yang tersedia.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Client-side search, filter, and sort untuk Dokumen SK
    
    function updateTable() {
        var searchValue = $('#searchInput').val().toLowerCase();
        var categoryValue = $('#categoryFilter').val();
        var statusValue = $('#statusFilter').val();
        var sortValue = $('#sortSelect').val();
        
        var rows = $('.sk-row').get();
        var matchCount = 0;
        
        // 1. Filtering
        $.each(rows, function(index, row) {
            var $row = $(row);
            var title = $row.data('title');
            var category = $row.data('category');
            var status = $row.data('status');
            
            var matchSearch = title.indexOf(searchValue) > -1;
            var matchCategory = categoryValue === 'all' || category === categoryValue;
            var matchStatus = statusValue === 'all' || status === statusValue;
            
            if (matchSearch && matchCategory && matchStatus) {
                $row.show();
                $row.addClass('filtered-visible');
                matchCount++;
            } else {
                $row.hide();
                $row.removeClass('filtered-visible');
            }
        });
        
        // 2. Sorting (hanya baris yang visible)
        var visibleRows = $('.sk-row.filtered-visible').get();
        visibleRows.sort(function(a, b) {
            if(sortValue === 'a-z') return $(a).data('title').localeCompare($(b).data('title'));
            if (sortValue === 'z-a') return $(b).data('title').localeCompare($(a).data('title'));
            if (sortValue === 'oldest') return $(a).data('date') - $(b).data('date');
            return $(b).data('date') - $(a).data('date'); // newest
        });
        
        // Append kembali untuk mengubah urutan DOM, skip index update agar nomor urut tetap sesuai jika dibutuhkan, atau update index agar selalu berurutan
        $.each(visibleRows, function(index, row) {
            $('#skTableBody').append(row);
            // Update the index number dynamically based on current sort/filter
            $(row).find('td:first').text(index + 1);
        });

        // 3. Handle empty state
        if(matchCount === 0 && $('.sk-row').length > 0) {
            if($('#noMatchRow').length === 0) {
                $('#skTableBody').append('<tr id="noMatchRow"><td colspan="7" class="text-center py-5 text-muted">Pencarian atau kombinasi filter tidak ditemukan.</td></tr>');
            }
        } else {
            $('#noMatchRow').remove();
        }
    }
    
    // Binding events
    $('#searchInput').on('keyup', updateTable);
    $('#categoryFilter, #statusFilter, #sortSelect').on('change', updateTable);
    
    // Panggil sekali saat load (opsional jika default = all filter)
    // updateTable();
});
</script>
@endpush
