@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size:24px;font-weight:700;">Data Mahasiswa</h1>
        <p style="font-size:14px;color:var(--on-surface-variant);">Daftar seluruh mahasiswa beserta hasil prediksi terakhir.</p>
    </div>
    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i>Tambah Mahasiswa
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($mahasiswas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Prediksi Terakhir</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswas as $index => $mhs)
                    <tr>
                        <td>{{ $mahasiswas->firstItem() + $index }}</td>
                        <td style="font-weight:500;">{{ $mhs->username_nim }}</td>
                        <td>{{ $mhs->name }}</td>
                        <td>{{ $mhs->angkatan ?? '-' }}</td>
                        <td>
                            @if($mhs->predictionResults->count() > 0)
                                @php $pred = $mhs->predictionResults->first(); @endphp
                                <span style="font-weight:600;color:var(--primary);">{{ $pred->persentase_keyakinan }}%</span>
                                <small style="color:var(--outline);">· {{ $pred->tanggal_prediksi->format('d M Y') }}</small>
                            @else
                                <span style="color:var(--outline);">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            @if($mhs->predictionResults->count() > 0)
                                @php $pred = $mhs->predictionResults->first(); @endphp
                                <span class="{{ $pred->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'badge-success-custom' : 'badge-danger-custom' }}">
                                    {{ Str::limit($pred->hasil_prediksi, 8) }}
                                </span>
                            @else
                                <span style="color:var(--outline);">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.mahasiswa.detail', $mhs->id) }}" class="btn btn-sm btn-outline-custom" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-outline-custom" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus mahasiswa {{ $mhs->name }}?\n\nData prediksi dan kuesioner mahasiswa ini juga akan dihapus permanen.\n\nKlik OK untuk melanjutkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-custom" title="Hapus" style="color:var(--danger-text);border-color:var(--danger-text);">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-3 pb-3 pt-2">{{ $mahasiswas->links() }}</div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-people" style="font-size:48px;color:var(--outline-variant);"></i>
            <p style="color:var(--on-surface-variant);margin-top:1rem;">Belum ada data mahasiswa.</p>
            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary-custom mt-2">
                <i class="bi bi-plus-lg me-2"></i>Tambah Mahasiswa Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
