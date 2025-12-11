<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateRiwayatStatusSuratDummy extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('riwayat_status_surat')->truncate();
        DB::statement('ALTER TABLE riwayat_status_surat AUTO_INCREMENT = 1');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pengajuans = DB::table('pengajuans')->get();
        if ($pengajuans->isEmpty()) {
            return;
        }

        $wargas = DB::table('warga')->get();
        $petugasIds = $wargas->pluck('warga_id')->toArray();

        $riwayatData = [];

        foreach ($pengajuans as $pengajuan) {
            $statusHistory = $this->generateStatusHistory($pengajuan->status, $pengajuan->created_at);

            foreach ($statusHistory as $history) {
                $petugasId = $history['status'] !== 'diajukan' && !empty($petugasIds)
                    ? $petugasIds[array_rand($petugasIds)]
                    : null;

                $keterangan = $this->getKeteranganByStatus($history['status'], $pengajuan->status);

                $riwayatData[] = [
                    'permohonan_id' => $pengajuan->permohonan_id,
                    'status' => $history['status'],
                    'petugas_warga_id' => $petugasId,
                    'waktu' => $history['waktu'],
                    'keterangan' => $keterangan,
                ];

                if (count($riwayatData) >= 100) {
                    DB::table('riwayat_status_surat')->insert($riwayatData);
                    $riwayatData = [];
                }
            }
        }

        if (!empty($riwayatData)) {
            DB::table('riwayat_status_surat')->insert($riwayatData);
        }
    }

    private function generateStatusHistory($finalStatus, $createdAt)
    {
        $history = [];
        $currentTime = Carbon::parse($createdAt);

        $statusFlow = ['diajukan'];

        if ($finalStatus === 'diproses') {
            $statusFlow = ['diajukan', 'diproses'];
        } elseif ($finalStatus === 'selesai') {
            $statusFlow = ['diajukan', 'diproses', 'selesai'];
        } elseif ($finalStatus === 'ditolak') {
            $statusFlow = ['diajukan', 'diproses', 'ditolak'];
        } elseif ($finalStatus === 'menunggu') {
            $statusFlow = ['diajukan'];
        }

        foreach ($statusFlow as $index => $status) {
            $timeOffset = $index * 86400;
            $history[] = [
                'status' => $status,
                'waktu' => $currentTime->copy()->addSeconds($timeOffset)
            ];
        }

        return $history;
    }

    private function getKeteranganByStatus($status, $finalStatus)
    {
        $keteranganMap = [
            'diajukan' => 'Pengajuan surat telah diterima',
            'diproses' => 'Sedang dalam proses pemeriksaan',
            'selesai' => 'Pengajuan telah selesai diproses',
            'ditolak' => 'Pengajuan ditolak',
            'menunggu' => 'Menunggu verifikasi',
        ];

        $keterangan = $keteranganMap[$status] ?? 'Status diperbarui';

        if ($status === 'ditolak') {
            $alasan = [
                'Berkas tidak lengkap',
                'Data tidak valid',
                'Tidak memenuhi syarat',
                'Dokumen kedaluwarsa',
                'Permohonan tidak sesuai'
            ];
            $keterangan .= ': ' . $alasan[array_rand($alasan)];
        }

        if ($status === 'selesai') {
            $keterangan .= '. Surat dapat diambil di kantor desa.';
        }

        return $keterangan;
    }
}
