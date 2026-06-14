<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Barang;
use App\Models\Lelang;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request, $id_barang)
    {
        $id_user = session('id_user');

        if (!$id_user) {
            return redirect()->route('login_masyarakat')->with('error', 'Silakan login terlebih dahulu');
        }

        $barang = Barang::findOrFail($id_barang);

        $existing = Wishlist::where('id_user', $id_user)
            ->where('id_barang', $id_barang)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Barang berhasil dihapus dari wishlist';
            $status = 'removed';
        } else {
            Wishlist::create([
                'id_user' => $id_user,
                'id_barang' => $id_barang,
            ]);
            $message = 'Barang berhasil ditambahkan ke wishlist';
            $status = 'added';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $id_user = session('id_user');

        if (!$id_user) {
            return redirect()->route('login_masyarakat');
        }

        $wishlist = Wishlist::with(['barang.lelang', 'barang.gambarUtama'])
            ->where('id_user', $id_user)
            ->orderByDesc('created_at')
            ->paginate(15);

        // Enrich dengan status lelang
        foreach ($wishlist as $item) {
            $lelang_aktif = $item->barang->lelang()
                ->where('status', 'dibuka')
                ->orderByDesc('id_lelang')
                ->first();

            $item->_lelang_aktif = $lelang_aktif;
        }

        return view('masyarakat.wishlist', compact('wishlist'));
    }
}
