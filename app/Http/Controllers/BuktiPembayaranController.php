<?php

namespace App\Http\Controllers;

use App\Models\Lelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuktiPembayaranController extends Controller
{
    public function upload(Request $request, $id_lelang)
    {
        $id_user = session('id_user');
        $lelang = Lelang::with('barang')->findOrFail($id_lelang);

        // Hanya pemenang yang bisa upload
        if ((int)$lelang->id_user !== (int)$id_user) {
            return back()->with('error', 'Anda bukan pemenang lelang ini.');
        }

        // Hanya bisa upload jika sudah dikonfirmasi
        if ($lelang->status_konfirmasi !== 'dikonfirmasi') {
            return back()->with('error', 'Bukti pembayaran hanya dapat diupload setelah konfirmasi kemenangan.');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $file = $request->file('bukti_pembayaran');
        $filename = Str::random(40) . '.' . $file->extension();

        $file->storeAs('bukti_bayar', $filename, 'public');

        return \DB::transaction(function () use ($lelang, $filename) {
            // Lock record to prevent concurrent updates
            $lelang = Lelang::where('id_lelang', $lelang->id_lelang)->lockForUpdate()->first();

            $oldFile = $lelang->bukti_pembayaran;

            $lelang->update([
                'bukti_pembayaran' => $filename,
                'tanggal_bayar' => now(),
            ]);

            // Delete old file after successful DB update
            if ($oldFile) {
                Storage::disk('public')->delete('bukti_bayar/' . $oldFile);
            }

            \App\Services\ActivityLog::record('upload_bukti_bayar', 'Lelang', $lelang->id_lelang);

            return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
        });
    }

    public function verifikasi(Request $request, $id_lelang)
    {
        $lelang = Lelang::findOrFail($id_lelang);

        if (!$lelang->bukti_pembayaran) {
            return back()->with('error', 'Belum ada bukti pembayaran yang diupload.');
        }

        $request->validate([
            'status' => 'required|in:dibayar,ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $status = $request->input('status');

        return \DB::transaction(function () use ($lelang, $status, $request) {
            // Lock record to prevent concurrent verifications
            $lelang = Lelang::where('id_lelang', $lelang->id_lelang)->lockForUpdate()->first();

            if ($status === 'dibayar') {
                $lelang->update([
                    'status_konfirmasi' => 'dibayar',
                    'catatan_admin' => $request->input('catatan'),
                ]);
                $message = 'Bukti pembayaran telah diverifikasi dan diterima.';

                // Kirim email notifikasi diterima
                if ($lelang->pemenang && $lelang->pemenang->email) {
                    \Mail::to($lelang->pemenang->email)->queue(new \App\Mail\BuktiPembayaranStatusMail(
                        $lelang->pemenang->nama_lengkap,
                        $lelang->barang->nama_barang,
                        'dibayar',
                        $request->input('catatan') ?: '',
                        route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang)
                    ));
                }
            } else {
                $oldFile = $lelang->bukti_pembayaran;

                $lelang->update([
                    'bukti_pembayaran' => null,
                    'tanggal_bayar' => null,
                    'catatan_admin' => $request->input('catatan') ?: 'Bukti pembayaran ditolak.',
                ]);

                // Delete rejected file after successful DB update
                if ($oldFile) {
                    Storage::disk('public')->delete('bukti_bayar/' . $oldFile);
                }

                $message = 'Bukti pembayaran ditolak. Pemenang perlu upload ulang.';

                // Kirim email notifikasi ditolak
                if ($lelang->pemenang && $lelang->pemenang->email) {
                    \Mail::to($lelang->pemenang->email)->queue(new \App\Mail\BuktiPembayaranStatusMail(
                        $lelang->pemenang->nama_lengkap,
                        $lelang->barang->nama_barang,
                        'ditolak',
                        $request->input('catatan') ?: 'Bukti pembayaran tidak jelas atau tidak sesuai.',
                        route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang)
                    ));
                }
            }

            \App\Services\ActivityLog::record('verifikasi_bukti_bayar', 'Lelang', $lelang->id_lelang, [
                'status' => $status,
                'catatan' => $request->input('catatan'),
            ]);

            return back()->with('success', $message);
        });
    }
}
