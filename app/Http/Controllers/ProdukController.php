<?php
// app/Http/Controllers/ProdukController.php
namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    // TIDAK ADA CONSTRUCTOR

    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:100',
            'status_produk' => 'required|in:aktif,nonaktif',
            'satuan' => 'nullable|max:20',
        ]);

        // Generate ID Produk
        $id_produk = 'PRD-' . Str::upper(Str::random(6));

        Produk::create([
            'id_produk' => $id_produk,
            'nama_produk' => $request->nama_produk,
            'status_produk' => $request->status_produk,
            'satuan' => $request->satuan ?? 'pcs',
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|max:100',
            'status_produk' => 'required|in:aktif,nonaktif',
            'satuan' => 'nullable|max:20',
        ]);

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'status_produk' => $request->status_produk,
            'satuan' => $request->satuan ?? 'pcs',
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
