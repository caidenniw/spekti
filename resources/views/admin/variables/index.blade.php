@extends('layouts.app')

@section('title', 'Kelola Variabel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size:24px;font-weight:700;">Variabel Penelitian</h1>
        <p style="font-size:14px;color:var(--on-surface-variant);">Kelola variabel yang digunakan dalam kuesioner prediksi.</p>
    </div>
    <a href="{{ route('admin.variables.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i>Tambah Variabel
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($variables->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Nama Variabel</th>
                        <th>Kode</th>
                        <th>Opsi Positif</th>
                        <th>Opsi Negatif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($variables as $var)
                    <tr>
                        <td>
                            <span style="font-weight:600;color:var(--primary);">{{ $var->urutan }}</span>
                        </td>
                        <td style="font-weight:500;">{{ $var->label }}</td>
                        <td>
                            <code style="font-size:12px;background:var(--bg);padding:2px 6px;border-radius:4px;">{{ $var->variable_name }}</code>
                        </td>
                        <td>
                            <span class="badge-success-custom" style="font-size:10px;">{{ $var->positif_label }}</span>
                        </td>
                        <td>
                            <span class="badge-danger-custom" style="font-size:10px;">{{ $var->negatif_label }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.variables.edit', $var->id) }}" class="btn btn-sm btn-outline-custom" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.variables.destroy', $var->id) }}" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus variabel \'{{ $var->label }}\'?\n\nVariabel ini digunakan dalam kuesioner mahasiswa. Menghapus variabel dapat mempengaruhi data prediksi yang sudah ada.\n\nKlik OK untuk melanjutkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-custom" title="Hapus" style="font-size:12px;color:var(--danger-text);border-color:var(--danger-text);">
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
        <div class="px-3 pb-3 pt-2">{{ $variables->links() }}</div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-grid-3x3-gap" style="font-size:48px;color:var(--outline-variant);"></i>
            <p style="color:var(--on-surface-variant);margin-top:1rem;">Belum ada variabel.</p>
            <a href="{{ route('admin.variables.create') }}" class="btn btn-primary-custom mt-2">
                <i class="bi bi-plus-lg me-2"></i>Tambah Variabel Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
