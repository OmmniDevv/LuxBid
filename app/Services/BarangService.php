<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\GambarBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BarangService
{
    public function store(array $data, Request $request): Barang
    {
        $barang = Barang::create([
            'nama_barang'      => $data['nama_barang'],
            'tgl'              => $data['tgl'],
            'harga_awal'       => $data['harga_awal'],
            'deskripsi_barang' => $data['deskripsi_barang'] ?? '',
            'nama_penjual'     => $data['nama_penjual'] ?? '',
            'id_kategori'      => $data['id_kategori'] ?: null,
        ]);

        $this->uploadGambar($request, $barang->id_barang);

        return $barang;
    }

    public function update(int $id_barang, array $data, Request $request): void
    {
        Barang::where('id_barang', $id_barang)->update([
            'nama_barang'      => $data['nama_barang'],
            'tgl'              => $data['tgl'],
            'harga_awal'       => $data['harga_awal'],
            'deskripsi_barang' => $data['deskripsi_barang'] ?? '',
            'nama_penjual'     => $data['nama_penjual'] ?? '',
            'id_kategori'      => $data['id_kategori'] ?: null,
        ]);

        $manager = new ImageManager(new Driver());
        $upload_dir = storage_path('app/public/barang');
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        for ($i = 1; $i <= 3; $i++) {
            if ($request->input("hapus_gambar_{$i}")) {
                $old = GambarBarang::where('id_barang', $id_barang)->where('urutan', $i)->first();
                if ($old) {
                    @unlink($upload_dir . '/' . $old->nama_file);
                    @unlink(public_path('uploads/barang/' . $old->nama_file)); // fallback lama
                    $old->delete();
                }
            }
            if ($request->hasFile("gambar_{$i}") && $request->file("gambar_{$i}")->isValid()) {
                $file     = $request->file("gambar_{$i}");
                $filename = Str::random(40) . '.webp';
                $manager->read($file->getRealPath())
                    ->scaleDown(width: 1200)
                    ->toWebp(quality: 80)
                    ->save($upload_dir . '/' . $filename);

                $existing = GambarBarang::where('id_barang', $id_barang)->where('urutan', $i)->first();
                if ($existing) {
                    @unlink($upload_dir . '/' . $existing->nama_file);
                    $existing->update(['nama_file' => $filename]);
                } else {
                    GambarBarang::create(['id_barang' => $id_barang, 'nama_file' => $filename, 'urutan' => $i]);
                }
            }
        }
    }

    public function delete(int $id_barang): void
    {
        GambarBarang::where('id_barang', $id_barang)->each(function ($g) {
            @unlink(storage_path('app/public/barang/' . $g->nama_file));
            // fallback: file lama mungkin masih di public/uploads/
            @unlink(public_path('uploads/barang/' . $g->nama_file));
        });
        GambarBarang::where('id_barang', $id_barang)->delete();
        Barang::where('id_barang', $id_barang)->delete();
    }

    private function uploadGambar(Request $request, int $id_barang): void
    {
        $upload_dir = storage_path('app/public/barang');
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $manager = new ImageManager(new Driver());

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("gambar_{$i}") && $request->file("gambar_{$i}")->isValid()) {
                $file = $request->file("gambar_{$i}");
                if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])) continue;
                if ($file->getSize() > 2 * 1024 * 1024) continue;

                $filename = Str::random(40) . '.webp';
                $manager->read($file->getRealPath())
                    ->scaleDown(width: 1200)
                    ->toWebp(quality: 80)
                    ->save($upload_dir . '/' . $filename);

                GambarBarang::create(['id_barang' => $id_barang, 'nama_file' => $filename, 'urutan' => $i]);
            }
        }
    }
}
