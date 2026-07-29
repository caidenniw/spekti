<?php

namespace Database\Seeders;

use App\Models\Variable;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    public function run(): void
    {
        $variables = [
            [
                'label'         => 'Indeks Prestasi Kumulatif (IPK)',
                'description'   => 'Pilih kondisi IPK yang paling sesuai dengan keadaan Anda saat ini. Setelah itu, tentukan seberapa yakin Anda bahwa kondisi tersebut benar menggambarkan keadaan Anda.',
                'variable_name' => 'ipk_status',
                'positif_value' => 'tinggi',
                'positif_label' => 'Tinggi (3.51 - 4.00)',
                'negatif_value' => 'rendah',
                'negatif_label' => 'Rendah (2.76 - 3.50)',
                'urutan'        => 1,
            ],
            [
                'label'         => 'Proses Pengerjaan Skripsi',
                'description'   => 'Pilih kondisi yang sesuai dengan progres pengerjaan skripsi Anda saat ini. Kemudian, tentukan tingkat keyakinan Anda terhadap jawaban yang dipilih.',
                'variable_name' => 'skripsi_status',
                'positif_value' => 'lancar',
                'positif_label' => 'Lancar',
                'negatif_value' => 'terlambat',
                'negatif_label' => 'Terlambat',
                'urutan'        => 2,
            ],
            [
                'label'         => 'Dukungan Keluarga',
                'description'   => 'Pilih kondisi yang menggambarkan dukungan keluarga yang Anda rasakan selama menjalani perkuliahan. Selanjutnya, pilih tingkat keyakinan Anda terhadap jawaban tersebut.',
                'variable_name' => 'dukungan_keluarga',
                'positif_value' => 'tinggi',
                'positif_label' => 'Tinggi',
                'negatif_value' => 'rendah',
                'negatif_label' => 'Rendah',
                'urutan'        => 3,
            ],
            [
                'label'         => 'Kualitas Dosen Pembimbing',
                'description'   => 'Pilih kondisi yang paling sesuai dengan pengalaman Anda dalam memperoleh bimbingan dari dosen pembimbing. Setelah itu, tentukan tingkat keyakinan Anda terhadap pilihan tersebut.',
                'variable_name' => 'kualitas_dosen',
                'positif_value' => 'baik',
                'positif_label' => 'Baik',
                'negatif_value' => 'kurang_baik',
                'negatif_label' => 'Kurang Baik',
                'urutan'        => 4,
            ],
            [
                'label'         => 'Kelengkapan Administrasi Perkuliahan',
                'description'   => 'Pilih kondisi yang sesuai dengan pengalaman Anda terhadap layanan administrasi akademik. Kemudian, tentukan seberapa yakin Anda terhadap jawaban yang dipilih.',
                'variable_name' => 'administrasi',
                'positif_value' => 'lengkap',
                'positif_label' => 'Lengkap',
                'negatif_value' => 'tidak_lengkap',
                'negatif_label' => 'Tidak Lengkap',
                'urutan'        => 5,
            ],
            [
                'label'         => 'Motivasi Diri',
                'description'   => 'Pilih kondisi yang paling menggambarkan motivasi Anda dalam menyelesaikan studi. Setelah itu, tentukan tingkat keyakinan Anda terhadap jawaban tersebut.',
                'variable_name' => 'motivasi_diri',
                'positif_value' => 'tinggi',
                'positif_label' => 'Tinggi',
                'negatif_value' => 'rendah',
                'negatif_label' => 'Rendah',
                'urutan'        => 6,
            ],
            [
                'label'         => 'Referensi atau Sumber Belajar',
                'description'   => 'Pilih kondisi yang sesuai dengan ketersediaan buku, jurnal, atau sumber referensi yang Anda gunakan dalam menyelesaikan skripsi. Selanjutnya, tentukan tingkat keyakinan Anda terhadap jawaban tersebut.',
                'variable_name' => 'referensi_belajar',
                'positif_value' => 'memadai',
                'positif_label' => 'Memadai',
                'negatif_value' => 'tidak_memadai',
                'negatif_label' => 'Tidak Memadai',
                'urutan'        => 7,
            ],
        ];

        foreach ($variables as $var) {
            Variable::create($var);
        }
    }
}
