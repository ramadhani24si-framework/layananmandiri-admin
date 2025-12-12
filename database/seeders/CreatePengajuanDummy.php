<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreatePengajuanDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel jika sudah ada data
        DB::table('pengajuans')->truncate();

        // Reset auto increment
        DB::statement('ALTER TABLE pengajuans AUTO_INCREMENT = 1');

        // Aktifkan kembali foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil semua data jenis surat
        $jenisSurats = DB::table('jenis_surat')->get();
        if ($jenisSurats->isEmpty()) {
            $this->command->error('❌ ERROR: Data jenis surat belum ada!');
            $this->command->info('   Jalankan dulu: php artisan db:seed --class=CreateJenisSuratDummy');
            return;
        }

        // Ambil semua data warga
        $wargas = DB::table('warga')->get();
        if ($wargas->isEmpty()) {
            $this->command->error('❌ ERROR: Data warga belum ada!');
            $this->command->info('   Jalankan dulu: php artisan db:seed --class=CreateWargaDummy');
            return;
        }

        $pengajuans = [];
        $nomorCounter = 1;
        $currentYear = date('Y');

        // Status pengajuan dan distribusi
        $statuses = [
            ['status' => 'menunggu', 'percent' => 35],
            ['status' => 'diproses', 'percent' => 30],
            ['status' => 'selesai', 'percent' => 25],
            ['status' => 'ditolak', 'percent' => 10],
        ];

        // Generate 100 data pengajuan dummy
        for ($i = 1; $i <= 100; $i++) {
            // Pilih jenis surat random
            $jenisSurat = $jenisSurats->random();

            // Pilih warga random
            $warga = $wargas->random();

            // Generate nomor permohonan: PENG/YYYY/MM/XXXX
            $nomorBulan = str_pad($faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
            $nomorUrut = str_pad($nomorCounter, 4, '0', STR_PAD_LEFT);
            $nomorPermohonan = "PENG/{$currentYear}/{$nomorBulan}/{$nomorUrut}";
            $nomorCounter++;

            // Tanggal pengajuan (random 2 tahun terakhir)
            $tanggalPengajuan = $faker->dateTimeBetween('-2 years', 'now');

            // Tentukan status berdasarkan distribusi persentase
            $statusRand = $faker->numberBetween(1, 100);
            $cumulativePercent = 0;
            $selectedStatus = 'menunggu'; // default

            foreach ($statuses as $statusInfo) {
                $cumulativePercent += $statusInfo['percent'];
                if ($statusRand <= $cumulativePercent) {
                    $selectedStatus = $statusInfo['status'];
                    break;
                }
            }

            $status = $selectedStatus;

            // Catatan berdasarkan status
            $catatan = null;

            if ($status === 'menunggu') {
                $catatan = $faker->boolean(40) ? 'Menunggu verifikasi berkas' : null;
            }
            elseif ($status === 'diproses') {
                $catatanOptions = [
                    'Sedang diproses oleh petugas',
                    'Menunggu tanda tangan lurah',
                    'Berkas sedang diperiksa',
                    'Proses validasi data',
                    'Menunggu disposisi'
                ];
                $catatan = $faker->randomElement($catatanOptions);
            }
            elseif ($status === 'selesai') {
                $catatanOptions = [
                    'Surat sudah selesai dan bisa diambil',
                    'Proses telah selesai',
                    'Surat telah dicetak dan distempel',
                    'Pengajuan telah disetujui',
                    'Berkas lengkap dan sudah diproses'
                ];
                $catatan = $faker->randomElement($catatanOptions);
            }
            elseif ($status === 'ditolak') {
                $alasanPenolakan = [
                    'Berkas tidak lengkap',
                    'Data KTP tidak valid',
                    'Tidak memenuhi syarat administrasi',
                    'Berkas foto tidak jelas',
                    'Surat pengantar RT/RW tidak sesuai',
                    'Data yang diisikan tidak benar',
                    'Berkas kedaluwarsa',
                    'Tidak melampirkan dokumen wajib',
                    'Permohonan tidak sesuai prosedur',
                    'Data tidak sesuai dengan fakta'
                ];
                $catatan = 'Ditolak: ' . $faker->randomElement($alasanPenolakan);
            }

            // Tanggal update berdasarkan status
            $updatedAt = $tanggalPengajuan;
            if ($status === 'diproses') {
                $updatedAt = $faker->dateTimeBetween($tanggalPengajuan, 'now');
            } elseif ($status === 'selesai' || $status === 'ditolak') {
                $updatedAt = $faker->dateTimeBetween($tanggalPengajuan, 'now');
            }

            $pengajuans[] = [
                'nomor_permohonan' => $nomorPermohonan,
                'warga_id' => $warga->warga_id,
                'jenis_id' => $jenisSurat->jenis_id,
                'tanggal_pengajuan' => $tanggalPengajuan->format('Y-m-d'),
                'status' => $status,
                'catatan' => $catatan,
                'created_at' => $tanggalPengajuan,
                'updated_at' => $updatedAt,
            ];

            // Insert batch setiap 20 data
            if ($i % 20 == 0) {
                DB::table('pengajuans')->insert($pengajuans);
                $pengajuans = [];
                $this->command->info("📄 Generated {$i} pengajuan...");
            }
        }

        // Insert sisa data jika ada
        if (!empty($pengajuans)) {
            DB::table('pengajuans')->insert($pengajuans);
        }

        // Hitung statistik
        $total = DB::table('pengajuans')->count();
        $menunggu = DB::table('pengajuans')->where('status', 'menunggu')->count();
        $diproses = DB::table('pengajuans')->where('status', 'diproses')->count();
        $selesai = DB::table('pengajuans')->where('status', 'selesai')->count();
        $ditolak = DB::table('pengajuans')->where('status', 'ditolak')->count();

        // Hitung persentase
        $persenMenunggu = round(($menunggu / $total) * 100, 1);
        $persenDiproses = round(($diproses / $total) * 100, 1);
        $persenSelesai = round(($selesai / $total) * 100, 1);
        $persenDitolak = round(($ditolak / $total) * 100, 1);

        // Statistik per jenis surat
        $this->command->info('│ 📈 DISTRIBUSI PER JENIS SURAT:                                │');

        $jenisStats = DB::table('pengajuans')
            ->join('jenis_surat', 'pengajuans.jenis_id', '=', 'jenis_surat.jenis_id')
            ->select('jenis_surat.nama_jenis', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_surat.jenis_id', 'jenis_surat.nama_jenis')
            ->orderByDesc('total')
            ->get();

        foreach ($jenisStats as $stat) {
            $persen = round(($stat->total / $total) * 100, 1);
            $barLength = round(($stat->total / $total) * 30);
            $bar = str_repeat('█', $barLength) . str_repeat('░', 30 - $barLength);
            $this->command->info("│   • " . str_pad($stat->nama_jenis, 30) . ": " . str_pad("{$stat->total} ({$persen}%)", 12) . " │");
        }

        // Ambil 5 contoh data terbaru
        $samples = DB::table('pengajuans')
            ->join('warga', 'pengajuans.warga_id', '=', 'warga.warga_id')
            ->join('jenis_surat', 'pengajuans.jenis_id', '=', 'jenis_surat.jenis_id')
            ->select('pengajuans.*', 'warga.nama as nama_warga', 'jenis_surat.nama_jenis')
            ->orderBy('pengajuans.created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($samples as $sample) {
            $statusBadge = match($sample->status) {
                'menunggu' => '⏳ MENUNGGU',
                'diproses' => '🔄 DIPROSES',
                'selesai' => '✅ SELESAI',
                'ditolak' => '❌ DITOLAK',
                default => '❓ UNKNOWN'
            };
        }
    }
}
