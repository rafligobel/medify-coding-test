<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class KategoriItemsController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriItem::query();

        if ($request->has('kode') && $request->kode != '') {
            $query->where('kode', $request->kode);
        }
        if ($request->has('nama') && $request->nama != '') {
            $query->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        $kategoris = $query->get();
        return view('kategori_items.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori_items.form');
    }

    public function store(Request $request)
    {
        KategoriItem::create($request->only(['kode', 'nama']));
        return redirect('/kategori-items');
    }

    public function edit($id)
    {
        $kategori = KategoriItem::find($id);
        return view('kategori_items.form', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriItem::find($id);
        $kategori->update($request->only(['kode', 'nama']));
        return redirect('/kategori-items');
    }

    public function destroy($id)
    {
        KategoriItem::destroy($id);
        return redirect('/kategori-items');
    }

    public function show($id)
    {
        $kategori = KategoriItem::with('masterItems')->find($id);
        return view('kategori_items.show', compact('kategori'));
    }

    // Fungsi Print PDF Detail Kategori
    public function downloadPdf($id)
    {
        $kategori = KategoriItem::with('masterItems')->find($id);

        $pdf = Pdf::loadView('kategori_items.pdf', compact('kategori'));
        return $pdf->download('kategori_detail_' . $kategori->kode . '.pdf');
    }
}
