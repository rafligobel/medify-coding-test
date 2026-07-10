<form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
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
            <option @if ($selected == 'Tokopaedi') selected @endif value="Tokopaedi">Tokopaedi</option>
            <option @if ($selected == 'Bukulapuk') selected @endif value="Bukulapuk">Bukulapuk</option>
            <option @if ($selected == 'TokoBagas') selected @endif value="TokoBagas">TokoBagas</option>
            <option @if ($selected == 'E Commurz') selected @endif value="E Commurz">E Commurz</option>
            <option @if ($selected == 'Blublu') selected @endif value="Blublu">Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group mb-3">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if ($selected == '') selected @endif value="">--Pilih--</option>
            <option @if ($selected == 'Obat') selected @endif value="Obat">Obat</option>
            <option @if ($selected == 'Alkes') selected @endif value="Alkes">Alkes</option>
            <option @if ($selected == 'Matkes') selected @endif value="Matkes">Matkes</option>
            <option @if ($selected == 'Umum') selected @endif value="Umum">Umum</option>
            <option @if ($selected == 'ATK') selected @endif value="ATK">ATK</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label>Foto Item (Opsional)</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        @if (isset($item->foto) && $item->foto != '')
            <small class="text-muted d-block mt-1">Sudah ada foto: <a href="{{ asset($item->foto) }}"
                    target="_blank">Lihat Foto</a></small>
        @endif
    </div>

    <div class="form-group mb-3">
        <label>Kategori</label>
        {{-- Tampilan telah diubah menjadi dropdown tunggal (seperti form Jenis) --}}
        <select name="kategori_ids[]" class="form-control">
            <option value="" disabled {{ empty($item_kategoris) ? 'selected' : '' }}>--Pilih--</option>
            @if (isset($kategoris))
                @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id }}" @if (isset($item_kategoris) && in_array($kat->id, $item_kategoris)) selected @endif>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>

</form>
