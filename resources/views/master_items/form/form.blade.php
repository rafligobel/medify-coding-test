<form method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method == 'edit')
        <div class="form-group mb-3">
            <label>Kode Barang</label>
            <input type="text" class="form-control" name="kode_barang" required readonly value="{{ $item->kode ?? '' }}">
        </div>
    @endif

    <div class="form-group mb-3">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $item->nama ?? '' }}">
    </div>

    <div class="form-group mb-3">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{ $item->harga_beli ?? '' }}">
    </div>

    <div class="form-group mb-3">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{ $item->laba ?? '' }}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group mb-3">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if ($selected == '') selected @endif value="">--Pilih--</option>
            <option @if ($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if ($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if ($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if ($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if ($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group mb-3">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if ($selected == '') selected @endif value="">--Pilih--</option>
            <option @if ($selected == 'Obat') selected @endif>Obat</option>
            <option @if ($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if ($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if ($selected == 'Umum') selected @endif>Umum</option>
            <option @if ($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    {{-- Field Upload Foto Baru --}}
    <div class="form-group mb-3">
        <label>Foto Item</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        @if (isset($item->foto) && $item->foto != '')
            <small class="text-muted d-block mt-1">Sudah ada foto: <a href="{{ asset($item->foto) }}"
                    target="_blank">Lihat Foto</a></small>
        @endif
    </div>

    {{-- Field Select Multiple Kategori Baru --}}
    <div class="form-group mb-3">
        <label>Kategori</label>
        <select name="kategori_ids[]" class="form-control" multiple required>
            @if (isset($kategoris))
                @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id }}" @if (isset($item_kategoris) && in_array($kat->id, $item_kategoris)) selected @endif>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            @endif
        </select>
        <small class="text-muted">Tekan CTRL (Windows) atau CMD (Mac) pada keyboard untuk memilih lebih dari 1
            kategori.</small>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>

</form>
