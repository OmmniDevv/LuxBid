<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\LelangTrait;
use App\Mail\KonfirmasiDiterimaMail;
use App\Models\Lelang;
use App\Models\RiwayatPemenangLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MasyarakatKonfirmasiController extends Controller
{
    use LelangTrait;
    public function show($id_lelang)
    {
        $id_user = session('id_user');

        $lelang = Lelang::with(['barang', 'pemenang'])->findOrFail($id_lelang);

        // Hanya pemenang yang boleh akses
        if ($lelang->status !== 'ditutup' || (int)$lelang->id_user !== (int)$id_user) {
            abort(403, 'Anda bukan pemenang lelang ini.');
        }

        // Cek apakah sudah ada rating
        $rating_existing = \App\Models\Rating::where('id_lelang', $id_lelang)
            ->where('id_user', $id_user)
            ->first();

        return view('masyarakat.konfirmasi_kemenangan', compact('lelang', 'rating_existing'));
    }

    public function konfirmasi(Request $request, $id_lelang)
    {
        $id_user = session('id_user');

        $lelang = Lelang::with(['barang', 'pemenang'])->findOrFail($id_lelang);

        // Hanya pemenang yang boleh akses
        if ($lelang->status !== 'ditutup' || (int)$lelang->id_user !== (int)$id_user) {
            abort(403, 'Anda bukan pemenang lelang ini.');
        }

        // Validasi: hanya bisa konfirmasi jika status masih 'menunggu_konfirmasi'
        if ($lelang->status_konfirmasi !== 'menunggu_konfirmasi') {
            return redirect()->route('masyarakat.konfirmasi_kemenangan', $id_lelang)
                ->with('error', 'Konfirmasi sudah tidak dapat dilakukan.');
        }

        $lelang->update([
            'status_konfirmasi' => 'dikonfirmasi',
            'tanggal_konfirmasi' => now(),
        ]);

        // Catat riwayat pemenang sebagai dikonfirmasi
        $urutan = RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)->count() + 1;
        RiwayatPemenangLelang::create([
            'id_lelang' => $lelang->id_lelang,
            'id_user' => $lelang->id_user,
            'urutan' => $urutan,
            'status' => 'dikonfirmasi'
        ]);

        // Catat activity log
        \App\Services\ActivityLog::record('konfirmasi_kemenangan', 'Lelang', $lelang->id_lelang);

        // Kirim email konfirmasi diterima
        if ($lelang->pemenang && $lelang->pemenang->email) {
            try {
                Mail::to($lelang->pemenang->email)->queue(new KonfirmasiDiterimaMail($lelang, $lelang->pemenang->nama_lengkap));
            } catch (\Exception) {}
        }

        return redirect()->route('masyarakat.konfirmasi_kemenangan', $id_lelang)
            ->with('success', 'Konfirmasi kesediaan berhasil! Silakan lanjutkan proses pembayaran.');
    }

    public function batalkan(Request $request, $id_lelang)
    {
        $id_user = session('id_user');

        $lelang = Lelang::with(['barang', 'pemenang'])->findOrFail($id_lelang);

        // Hanya pemenang yang boleh akses
        if ($lelang->status !== 'ditutup' || (int)$lelang->id_user !== (int)$id_user) {
            abort(403, 'Anda bukan pemenang lelang ini.');
        }

        // Validasi: hanya bisa batalkan jika status masih 'menunggu_konfirmasi'
        if ($lelang->status_konfirmasi !== 'menunggu_konfirmasi') {
            return redirect()->route('masyarakat.konfirmasi_kemenangan', $id_lelang)
                ->with('error', 'Pembatalan sudah tidak dapat dilakukan.');
        }

        $catatan = $request->input('catatan', 'Dibatalkan oleh pemenang');

        // Catat activity log sebelum lempar ke penawar kedua
        \App\Services\ActivityLog::record('batalkan_kemenangan', 'Lelang', $lelang->id_lelang, ['catatan' => $catatan]);

        // Lempar ke penawar kedua
        $adaPengganti = $this->lemparKePenawarKedua($lelang, $catatan);

        if ($adaPengganti) {
            return redirect()->route('masyarakat.konfirmasi_kemenangan', $id_lelang)
                ->with('info', 'Kemenangan telah dibatalkan. Lelang telah dilempar ke penawar tertinggi berikutnya.');
        } else {
            return redirect()->route('masyarakat.konfirmasi_kemenangan', $id_lelang)
                ->with('info', 'Kemenangan telah dibatalkan. Tidak ada penawar pengganti yang tersedia.');
        }
    }
}
