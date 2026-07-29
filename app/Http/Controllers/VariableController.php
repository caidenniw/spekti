<?php

namespace App\Http\Controllers;

use App\Models\Variable;
use Illuminate\Http\Request;

class VariableController extends Controller
{
    /** Daftar semua variabel. */
    public function index()
    {
        $variables = Variable::orderBy('urutan')->paginate(15);
        return view('admin.variables.index', compact('variables'));
    }

    /** Form tambah variabel baru. */
    public function create()
    {
        $nextUrutan = Variable::max('urutan') + 1;
        return view('admin.variables.create', compact('nextUrutan'));
    }

    /** Simpan variabel baru. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'         => 'required|string|max:255',
            'variable_name' => 'required|string|max:100|unique:variables,variable_name|regex:/^[a-z_]+$/',
            'positif_value' => 'required|string|max:100',
            'positif_label' => 'required|string|max:255',
            'negatif_value' => 'required|string|max:100',
            'negatif_label' => 'required|string|max:255',
            'urutan'        => 'required|integer|min:1',
        ], [
            'label.required'              => 'Nama variabel wajib diisi.',
            'variable_name.required'      => 'Kode variabel wajib diisi.',
            'variable_name.unique'        => 'Kode variabel sudah ada.',
            'variable_name.regex'         => 'Kode variabel hanya boleh huruf kecil dan underscore (contoh: ipk_status).',
            'positif_value.required'      => 'Nilai positif wajib diisi.',
            'positif_label.required'      => 'Label positif wajib diisi.',
            'negatif_value.required'      => 'Nilai negatif wajib diisi.',
            'negatif_label.required'      => 'Label negatif wajib diisi.',
            'urutan.required'             => 'Urutan wajib diisi.',
        ]);

        Variable::create($validated);

        return redirect()->route('admin.variables.index')
            ->with('success', "Variabel \"{$validated['label']}\" berhasil ditambahkan.");
    }

    /** Form edit variabel. */
    public function edit($id)
    {
        $variable = Variable::findOrFail($id);
        return view('admin.variables.edit', compact('variable'));
    }

    /** Update variabel. */
    public function update(Request $request, $id)
    {
        $variable = Variable::findOrFail($id);

        $validated = $request->validate([
            'label'         => 'required|string|max:255',
            'variable_name' => 'required|string|max:100|unique:variables,variable_name,' . $variable->id . '|regex:/^[a-z_]+$/',
            'positif_value' => 'required|string|max:100',
            'positif_label' => 'required|string|max:255',
            'negatif_value' => 'required|string|max:100',
            'negatif_label' => 'required|string|max:255',
            'urutan'        => 'required|integer|min:1',
        ], [
            'label.required'              => 'Nama variabel wajib diisi.',
            'variable_name.required'      => 'Kode variabel wajib diisi.',
            'variable_name.unique'        => 'Kode variabel sudah ada.',
            'variable_name.regex'         => 'Kode variabel hanya boleh huruf kecil dan underscore.',
            'positif_value.required'      => 'Nilai positif wajib diisi.',
            'positif_label.required'      => 'Label positif wajib diisi.',
            'negatif_value.required'      => 'Nilai negatif wajib diisi.',
            'negatif_label.required'      => 'Label negatif wajib diisi.',
            'urutan.required'             => 'Urutan wajib diisi.',
        ]);

        $variable->update($validated);

        return redirect()->route('admin.variables.index')
            ->with('success', "Variabel \"{$variable->label}\" berhasil diperbarui.");
    }

    /** Hapus variabel. */
    public function destroy($id)
    {
        $variable = Variable::findOrFail($id);
        $nama = $variable->label;
        $variable->delete();

        return redirect()->route('admin.variables.index')
            ->with('success', "Variabel \"{$nama}\" berhasil dihapus.");
    }
}
