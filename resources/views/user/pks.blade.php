@extends('layouts.app')

@push('styles')
<style>
    .modern-table-card {
        border-radius: 12px;
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
</style>
@endpush

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 mt-4 border-bottom pb-3">
    <h2 class="fw-bold m-0 text-dark">Arsip PKS</h2>
</div>

<div class="row mb-3 g-2">
    <div class="col-md-5">
        <div class="input-group shadow-sm" style="border-radius: 8px;">
            <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control border-start-0 shadow-none" placeholder="Cari Judul PKS...">
        </div>
    </div>
    <div class="col-md-3">
        <select id="statusFilter" class="form-select shadow-sm" style="border-radius: 8px;">
            <option value="all">Semua Status</option>
            <option value="berlaku">Berlaku</option>
            <option value="tidak_berlaku">Tidak Berlaku</option>
        </select>
    </div>
    <div class="col-md-4">
        <div class="input-group shadow-sm" style="border-radius: 8px;">
            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-sort-amount-down"></i></span>
            <select id="sortSelect" class="form-select border-start-0 shadow-none">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
            </select>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm modern-table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 modern-table" id="pksTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Judul Regulasi</th>
                        <th>File</th>
                        <th>Tanggal Upload</th>
                        <th>Tgl Berlaku</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pks as $index => $item)
                    <tr class="pks-row" data-title="{{ strtolower($item->title) }}" data-status="{{ $item->status }}" data-date="{{ $item->effective_date ? \Carbon\Carbon::parse($item->effective_date)->timestamp : 0 }}">
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $item->title }}</td>
                        <td>
                            @if($item->file_path)
                            <div class="d-flex gap-3">
                                <a href="{{ route('pks.view', $item->id) }}" target="_blank" class="text-info fw-bold text-decoration-none" title="Lihat File">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </a>
                                <a href="{{ route('pks.download', $item->id) }}" class="text-primary fw-bold text-decoration-none" title="Unduh File">
                                    <i class="fas fa-download me-1"></i> Unduh
                                </a>
                            </div>
                            @else
                            <span class="badge bg-light text-muted border px-3 py-2 rounded-pill"><i class="fas fa-ban me-1"></i> Tidak Ada File</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>{{ $item->effective_date ? \Carbon\Carbon::parse($item->effective_date)->format('d M Y') : '-' }}</td>
                        <td>
                            @if($item->status == 'berlaku') <span class="badge bg-success rounded-pill px-3">Berlaku</span>
                            @else <span class="badge bg-danger rounded-pill px-3">Tidak Berlaku</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open mb-2 fs-2"></i><br>
                            Belum ada Arsip PKS yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function filterPks() {
        var searchValue = $('#searchInput').val().toLowerCase();
        var statusValue = $('#statusFilter').val();
        var sortValue = $('#sortSelect').val();

        var matchCount = 0;
        var visibleRows = [];

        $('.pks-row').each(function() {
            var title = $(this).data('title');
            var status = $(this).data('status');

            var matchSearch = title.indexOf(searchValue) > -1;
            var matchStatus = statusValue === 'all' || status === statusValue;

            if (matchSearch && matchStatus) {
                $(this).show();
                visibleRows.push(this);
                matchCount++;
            } else {
                $(this).hide();
            }
        });

        visibleRows.sort(function(a, b) {
            if (sortValue === 'oldest') {
                return $(a).data('date') - $(b).data('date');
            }
            return $(b).data('date') - $(a).data('date');
        });

        var tbody = $('table tbody');
        $.each(visibleRows, function(index, row) {
            tbody.append(row);
            $(row).find('td:first').text(index + 1);
        });

        if (matchCount === 0 && $('.pks-row').length > 0) {
            if ($('#noMatchRow').length === 0) {
                $('tbody').append('<tr id="noMatchRow"><td colspan="6" class="text-center py-5 text-muted">Pencarian tidak ditemukan.</td></tr>');
            }
        } else {
            $('#noMatchRow').remove();
        }
    }

    $('#searchInput').on('keyup', filterPks);
    $('#statusFilter, #sortSelect').on('change', filterPks);
});
</script>
@endpush
