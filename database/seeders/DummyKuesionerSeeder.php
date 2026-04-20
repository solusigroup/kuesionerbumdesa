<?php

namespace Database\Seeders;

use App\Models\Kuesioner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DummyKuesionerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kabupaten = [
            'Kabupaten Bangkalan', 'Kabupaten Banyuwangi', 'Kabupaten Blitar', 'Kabupaten Bojonegoro',
            'Kabupaten Bondowoso', 'Kabupaten Gresik', 'Kabupaten Jember', 'Kabupaten Jombang',
            'Kabupaten Kediri', 'Kabupaten Lamongan', 'Kabupaten Lumajang', 'Kabupaten Madiun',
            'Kabupaten Magetan', 'Kabupaten Malang', 'Kabupaten Mojokerto', 'Kabupaten Nganjuk',
            'Kabupaten Ngawi', 'Kabupaten Pacitan', 'Kabupaten Pamekasan', 'Kabupaten Pasuruan',
            'Kabupaten Ponorogo', 'Kabupaten Probolinggo', 'Kabupaten Sampang', 'Kabupaten Sidoarjo',
            'Kabupaten Situbondo', 'Kabupaten Sumenep', 'Kabupaten Trenggalek', 'Kabupaten Tuban',
            'Kabupaten Tulungagung', 'Kota Batu', 'Kota Blitar', 'Kota Kediri',
            'Kota Madiun', 'Kota Malang', 'Kota Mojokerto', 'Kota Pasuruan',
            'Kota Probolinggo', 'Kota Surabaya'
        ];

        $jabatans = ['Direktur', 'Sekretaris', 'Bendahara', 'Pengawas', 'Staff', 'Lainnya'];
        $pendidikans = ['SD', 'SMP', 'SMA/SMK', 'Diploma', 'S1', 'S2', 'S3'];
        $lamaMenjabat = ['Kurang dari 1 tahun', '1 sampai 3 tahun', '4 sampai 6 tahun', 'Lebih dari 6 tahun'];
        $frekuensi = ['Tidak pernah', '1 kali', '2 sampai 3 kali', 'Lebih dari 3 kali'];

        for ($i = 0; $i < 50; $i++) {
            // Create a unique user for each respondent
            $respondentName = $faker->name;
            $user = User::create([
                'name' => $respondentName,
                'email' => "respondent{$i}_" . $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'role' => 'user'
            ]);

            // Random base scores to create some correlation
            $baseX1 = rand(3, 5);
            $baseX2 = rand(1, 4);
            $baseX3 = rand(1, 4);
            
            // Y is influenced positively by X1 and negatively by X2/X3
            $baseY = round(($baseX1 * 0.6) + ( (5 - $baseX2) * 0.2 ) + ( (5 - $baseX3) * 0.2 ));
            $baseY = max(1, min(5, $baseY));

            $data = [
                'user_id' => $user->id,
                'nama_responden' => $respondentName,
                'nomor_wa' => $faker->numerify('081###########'),
                'email_bumdesa' => $faker->email,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'usia' => rand(25, 60),
                'jabatan' => $faker->randomElement($jabatans),
                'nama_bumdesa' => 'BUMDesa ' . $faker->company,
                'nama_desa' => 'Desa ' . $faker->streetName,
                'kecamatan' => 'Kecamatan ' . $faker->city,
                'kabupaten_kota' => $faker->randomElement($kabupaten),
                'lama_menjabat' => $faker->randomElement($lamaMenjabat),
                'pendidikan_terakhir' => $faker->randomElement($pendidikans),
                'pernah_pelatihan' => $faker->randomElement(['Ya', 'Tidak']),
                'menggunakan_aplikasi' => $faker->randomElement(['Ya', 'Tidak']),
                'frekuensi_pelatihan' => $faker->randomElement($frekuensi),
                'hambatan_besar' => $faker->sentence,
                'pengaruh_budaya' => $faker->sentence,
                'perbaikan_dibutuhkan' => $faker->sentence,
            ];

            // Fill scale questions with some noise around base scores
            for ($j = 1; $j <= 5; $j++) {
                $data["x1_$j"] = max(1, min(5, $baseX1 + rand(-1, 1)));
                $data["x2_$j"] = max(1, min(5, $baseX2 + rand(-1, 1)));
                $data["x3_$j"] = max(1, min(5, $baseX3 + rand(-1, 1)));
                $data["y$j"]    = max(1, min(5, $baseY + rand(-1, 1)));
            }

            Kuesioner::create($data);
        }
    }
}
