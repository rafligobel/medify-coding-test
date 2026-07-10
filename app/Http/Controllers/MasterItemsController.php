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

        if (isset($hargamin) && $hargamin !== '') {
            $data_search->where('harga_beli', '>=', $hargamin);
        }
        if (isset($hargamax) && $hargamax !== '') {
            $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'foto')->orderBy('id', 'desc')->get();

        return response()->json([
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
            $max_id = MasterItem::withTrashed()->max('id') ?? 0;
            $kode = $max_id + 1;
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
                <th style="background-color: #f2f2f2;">No</th>
                <th style="background-color: #f2f2f2;">Nama Kategori</th>
                <th style="background-color: #f2f2f2;">Nama Items</th>
                <th style="background-color: #f2f2f2;">Nama Supplier</th>
                <th style="background-color: #f2f2f2;">Harga</th>
                <th style="background-color: #f2f2f2;">Laba (%)</th>
                <th style="background-color: #f2f2f2;">Harga Jual</th>
              </tr>';

        $no = 1;
        foreach ($items as $item) {
            $kategoriNames = $item->kategoris->pluck('nama')->implode(', ');

            $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $kategoriNames . '</td>';
            echo '<td>' . $item->nama . '</td>';
            echo '<td>' . $item->supplier . '</td>';
            echo '<td>' . $item->harga_beli . '</td>';
            echo '<td>' . $item->laba . '</td>';
            echo '<td>' . round($hargaJual) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit;
    }
}
