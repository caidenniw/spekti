@extends('layouts.app')

@section('title', 'Kelola Rules CF')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size:24px;font-weight:700;">Knowledge Base Rules</h1>
        <p style="font-size:14px;color:var(--on-surface-variant);">Aturan IF-THEN dan bobot Certainty Factor dari Pakar.</p>
    </div>
    <a href="{{ route('admin.rules.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i>Tambah Rule
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($rules->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Deskripsi Rule</th>
                        <th>CF Pakar</th>
                        <th>Prediksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rules as $rule)
                    <tr>
                        <td><span style="font-weight:600;color:var(--primary);">{{ $rule->kode_rule }}</span></td>
                        <td style="max-width:400px;">{{ $rule->deskripsi_rule }}</td>
                        <td>
                            <span style="font-weight:600;color:var(--primary);">
                                {{ number_format($rule->cf_pakar, 2) }}
                            </span>
                        </td>
                        <td>
                            <span class="{{ $rule->status_prediksi === 'Lulus' ? 'badge-success-custom' : 'badge-danger-custom' }}">
                                {{ $rule->status_prediksi }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.rules.edit', $rule->id) }}" class="btn btn-sm btn-outline-custom" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.rules.destroy', $rule->id) }}" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus rule {{ $rule->kode_rule }}?\n\nRule ini akan dihapus dari knowledge base dan tidak akan digunakan lagi dalam perhitungan prediksi.\n\nKlik OK untuk melanjutkan.')">
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
        <div class="px-3 pb-3 pt-2">{{ $rules->links() }}</div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-lightning" style="font-size:48px;color:var(--outline-variant);"></i>
            <p style="color:var(--on-surface-variant);margin-top:1rem;">Belum ada rules.</p>
            <a href="{{ route('admin.rules.create') }}" class="btn btn-primary-custom mt-2">
                <i class="bi bi-plus-lg me-2"></i>Tambah Rule Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
