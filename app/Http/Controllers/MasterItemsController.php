<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\KategoriItem;
use Illuminate\Http\Request;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::with('kategoris');

        if (!empty($kode)) $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        if (!empty($hargamin)) {
            $data_search->where('harga_beli', '>=', $hargamin);
        }
        if (!empty($hargamax)) {
            $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'foto')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        $kategoris = KategoriItem::all();
        $item_kategoris = [];

        if ($method == 'new') {
            $item = new MasterItem;
        } else {
            $item = MasterItem::with('kategoris')->find($id);
            if ($item) {
                $item_kategoris = $item->kategoris->pluck('id')->toArray();
            }
        }

        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategoris'] = $kategoris;
        $data['item_kategoris'] = $item_kategoris;

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategoris')->where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count();
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;

        // Proses Upload Foto 
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/master_items'), $filename);
            $data_item->foto = 'uploads/master_items/' . $filename;
        }

        $data_item->save();

        if ($request->has('kategori_ids')) {
            $data_item->kategoris()->sync($request->kategori_ids);
        } else {
            $data_item->kategoris()->detach();
        }

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function exportExcel()
    {
        $items = MasterItem::with('kategoris')->get();
        $filename = "Master_Items_" . date('Ymd') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo '<table border="1">';
        echo '<tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Nama Items</th>
                <th>Nama Supplier</th>
                <th>Harga</th>
                <th>Laba</th>
                <th>Harga Jual</th>
              </tr>'; // [cite: 19, 20, 21, 22, 23, 24, 25]

        $no = 1;
        foreach ($items as $item) {
            $kategoriNames = $item->kategoris->pluck('nama')->implode(', ');
            $hargaJual = $item->harga_beli + $item->laba;

            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $kategoriNames . '</td>';
            echo '<td>' . $item->nama . '</td>';
            echo '<td>' . $item->supplier . '</td>';
            echo '<td>' . $item->harga_beli . '</td>';
            echo '<td>' . $item->laba . '</td>';
            echo '<td>' . $hargaJual . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit;
    }
}
