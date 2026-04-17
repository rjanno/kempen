@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 mt-4">
    <h2>Manajemen Regulasi Internal</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSKModal">
        <i class="fas fa-plus me-1"></i> Tambah Regulasi Internal
    </button>
</div>

<div class="row mb-3 g-2">
    <div class="col-md-4">
        <div class="input-group shadow-sm" style="border-radius: 8px;">
            <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-search"></i></span>
            <input type="text" id="adminSearchInput" class="form-control border-start-0 shadow-none" placeholder="Cari Judul Regulasi Internal...">
        </div>
    </div>
    <div class="col-md-3">
        <select id="adminCategoryFilter" class="form-select shadow-sm" style="border-radius: 8px;">
            <option value="all">Semua Kategori</option>
            <option value="sk">SK</option>
            <option value="kpo">KPO</option>
            <option value="spo">SPO</option>
            <option value="mi">MI</option>
            <option value="se">SE</option>
        </select>
    </div>
    <div class="col-md-2">
        <select id="adminStatusFilter" class="form-select shadow-sm" style="border-radius: 8px;">
            <option value="all">Semua Status</option>
            <option value="berlaku">Berlaku</option>
            <option value="tidak_berlaku">Tidak Berlaku</option>
        </select>
    </div>
    <div class="col-md-3">
        <div class="input-group shadow-sm" style="border-radius: 8px;">
            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-sort-amount-down"></i></span>
            <select id="adminSortSelect" class="form-select border-start-0 shadow-none">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
            </select>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Judul SK</th>
                        <th>File</th>
                        <th>Tanggal Upload</th>
                        <th>Tgl Berlaku</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($policies as $index => $sk)
                    <tr class="admin-sk-row" data-title="{{ strtolower($sk->title) }}" data-category="{{ $sk->category }}" data-status="{{ $sk->status }}" data-date="{{ $sk->created_at->timestamp }}">
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td class="fw-medium">{{ $sk->title }}</td>
                        <td>
                            @if($sk->file_path)
                            <div class="d-flex gap-3">
                                <a href="{{ route('sk.view', $sk->id) }}" target="_blank" class="text-primary text-decoration-none" title="Lihat File">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </a>
                                <a href="{{ route('sk.download', $sk->id) }}" class="text-danger text-decoration-none" title="Unduh File">
                                    <i class="fas fa-download me-1"></i> Unduh
                                </a>
                            </div>
                            @else
                            <span class="text-muted">Tidak ada file</span>
                            @endif
                        </td>
                        <td>{{ $sk->created_at->format('d M Y') }}</td>
                        <td>{{ $sk->effective_date ? \Carbon\Carbon::parse($sk->effective_date)->format('d M Y') : '-' }}</td>
                        <td>
                            @if($sk->category == 'sk') <span class="badge bg-primary">SK</span>
                            @elseif($sk->category == 'kpo') <span class="badge bg-info">KPO</span>
                            @elseif($sk->category == 'spo') <span class="badge bg-success">SPO</span>
                            @elseif($sk->category == 'mi') <span class="badge bg-warning text-dark">MI</span>
                            @elseif($sk->category == 'se') <span class="badge bg-secondary">SE</span>
                            @else <span class="badge bg-light text-dark">{{ strtoupper($sk->category) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($sk->status == 'berlaku') <span class="badge bg-success">Berlaku</span>
                            @else <span class="badge bg-danger">Tidak Berlaku</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editSKModal{{ $sk->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.sk.destroy', $sk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SK ini? File PDF juga akan terhapus.');">
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
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-folder-open mb-2 fs-2"></i><br>
                            Belum ada Surat Keputusan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($policies as $sk)
<!-- Modal Edit SK -->
<div class="modal fade" id="editSKModal{{ $sk->id }}" tabindex="-1" aria-labelledby="editSKModalLabel{{ $sk->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.sk.update', $sk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editSKModalLabel{{ $sk->id }}"><i class="fas fa-edit me-2"></i>Edit SK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title{{ $sk->id }}" class="form-label fw-bold">Judul Surat Keputusan</label>
                        <input type="text" class="form-control" id="title{{ $sk->id }}" name="title" value="{{ $sk->title }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="effective_date{{ $sk->id }}" class="form-label fw-bold">Tanggal Berlaku</label>
                            <input type="date" class="form-control" id="effective_date{{ $sk->id }}" name="effective_date" value="{{ $sk->effective_date }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status{{ $sk->id }}" class="form-label fw-bold">Status SK</label>
                            <select class="form-select" id="status{{ $sk->id }}" name="status" required>
                                <option value="berlaku" {{ $sk->status == 'berlaku' ? 'selected' : '' }}>Berlaku</option>
                                <option value="tidak_berlaku" {{ $sk->status == 'tidak_berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category{{ $sk->id }}" class="form-label fw-bold">Kategori/Peruntukan</label>
                        <select class="form-select" id="category{{ $sk->id }}" name="category" required>
                            <option value="sk" {{ $sk->category == 'sk' ? 'selected' : '' }}>SK</option>
                            <option value="kpo" {{ $sk->category == 'kpo' ? 'selected' : '' }}>KPO</option>
                            <option value="spo" {{ $sk->category == 'spo' ? 'selected' : '' }}>SPO</option>
                            <option value="mi" {{ $sk->category == 'mi' ? 'selected' : '' }}>MI</option>
                            <option value="se" {{ $sk->category == 'se' ? 'selected' : '' }}>SE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file{{ $sk->id }}" class="form-label fw-bold">Pilih File PDF Baru (Opsional)</label>
                        <input type="file" class="form-control" id="file{{ $sk->id }}" name="file" accept="application/pdf">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah file draft yang ada. Maksimal ukuran file: 10MB.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update SK</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah SK -->
<div class="modal fade" id="tambahSKModal" tabindex="-1" aria-labelledby="tambahSKModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.sk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahSKModalLabel"><i class="fas fa-file-pdf me-2"></i>Tambah SK Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Surat Keputusan</label>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="Contoh: SK Pengangkatan Pegawai 2026">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="effective_date" class="form-label fw-bold">Tanggal Berlaku</label>
                            <input type="date" class="form-control" id="effective_date" name="effective_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">Status SK</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="berlaku" selected>Berlaku</option>
                                <option value="tidak_berlaku">Tidak Berlaku</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label fw-bold">Kategori/Peruntukan</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="sk">SK</option>
                            <option value="kpo">KPO</option>
                            <option value="spo">SPO</option>
                            <option value="mi">MI</option>
                            <option value="se">SE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label fw-bold">Pilih File PDF</label>
                        <input type="file" class="form-control" id="file" name="file" accept="application/pdf" required>
                        <div class="form-text">Maksimal ukuran file: 10MB. Format harus .pdf.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan SK</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function filterPolicies() {
        var searchValue = $('#adminSearchInput').val().toLowerCase();
        var categoryValue = $('#adminCategoryFilter').val();
        var statusValue = $('#adminStatusFilter').val();
        var sortValue = $('#adminSortSelect').val();

        var matchCount = 0;
        var visibleRows = [];

        $('.admin-sk-row').each(function() {
            var title = $(this).data('title');
            var category = $(this).data('category');
            var status = $(this).data('status');

            var matchSearch = title.indexOf(searchValue) > -1;
            var matchCategory = categoryValue === 'all' || category === categoryValue;
            var matchStatus = statusValue === 'all' || status === statusValue;

            if (matchSearch && matchCategory && matchStatus) {
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

        if (matchCount === 0 && $('.admin-sk-row').length > 0) {
            if ($('#adminNoMatchRow').length === 0) {
                $('tbody').append('<tr id="adminNoMatchRow"><td colspan="8" class="text-center py-4 text-muted">Pencarian tidak ditemukan.</td></tr>');
            }
        } else {
            $('#adminNoMatchRow').remove();
        }
    }

    $('#adminSearchInput').on('keyup', filterPolicies);
    $('#adminCategoryFilter, #adminStatusFilter, #adminSortSelect').on('change', filterPolicies);
});
</script>
@endpush
