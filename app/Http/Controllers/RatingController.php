<?php

namespace App\Http\Controllers;

use App\Models\Lelang;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, $id_lelang)
    {
        $id_user = session('id_user');

        $lelang = Lelang::findOrFail($id_lelang);

        // Hanya pemenang yang bisa rating
        if ((int)$lelang->id_user !== (int)$id_user) {
            return back()->with('error', 'Hanya pemenang yang dapat memberikan rating.');
        }

        // Hanya bisa rating jika sudah dikonfirmasi atau selesai
        if (!in_array($lelang->status_konfirmasi, ['dikonfirmasi', 'selesai'])) {
            return back()->with('error', 'Rating hanya dapat diberikan setelah konfirmasi kemenangan.');
        }

        // Validasi
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        // Cek apakah sudah pernah rating
        $existing = Rating::where('id_lelang', $id_lelang)
            ->where('id_user', $id_user)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan rating untuk lelang ini.');
        }

        Rating::create([
            'id_lelang' => $id_lelang,
            'id_user' => $id_user,
            'rating' => $request->input('rating'),
            'komentar' => $request->input('komentar'),
        ]);

        return back()->with('success', 'Terima kasih atas rating Anda!');
    }
}
